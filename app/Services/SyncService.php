<?php

namespace App\Services;

use App\Models\SyncLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SyncService
{
    public function __construct(
        private UserServiceClient $client
    ) {}

    // ── Full sync — all users both directions ─────────────────

    public function fullSync(?int $triggeredBy = null): SyncLog
    {
        $log = SyncLog::create([
            'sync_type'    => $triggeredBy ? 'manual' : 'full',
            'direction'    => 'reconcile',
            'started_at'   => now(),
            'triggered_by' => $triggeredBy,
        ]);

        if (! $this->client->isConfigured()) {
            return $this->completeLog($log, 0, 0, 0, 0, [], [
                ['reason' => 'User Service not configured — skipping sync'],
            ]);
        }

        $conflicts = [];
        $errors    = [];
        $synced    = 0;
        $skipped   = 0;
        $total     = 0;

        // ── Step 1: Push FlowDesk users to User Service ───────
        $localUsers = User::whereNull('deleted_at')->get();
        $total = $localUsers->count();

        foreach ($localUsers as $user) {
            try {
                $result = $this->pushUserToService($user);

                match ($result['outcome']) {
                    'synced'   => $synced++,
                    'skipped'  => $skipped++,
                    'conflict' => ($conflicts[] = $result['detail']) && $synced++,
                    default    => null,
                };
            } catch (\Exception $e) {
                $errors[] = [
                    'pf_number' => $user->pf_number,
                    'error'     => $e->getMessage(),
                ];
            }
        }

        // ── Step 2: Pull from User Service → update locals ────
        $offset = 0;
        $limit  = 100;

        do {
            $response = $this->client->listUsers($limit, $offset);
            if (! $response || empty($response['data'])) break;

            foreach ($response['data'] as $remoteUser) {
                try {
                    $this->pullUserFromService($remoteUser);
                } catch (\Exception $e) {
                    $errors[] = [
                        'pf_number' => $remoteUser['pf_number'] ?? 'unknown',
                        'error'     => $e->getMessage(),
                    ];
                }
            }

            $offset += $limit;
        } while (count($response['data']) === $limit);

        return $this->completeLog($log, $total, $synced, count($conflicts), count($errors), $conflicts, $errors);
    }

    // ── Delta sync — only changed records since last sync ─────

    public function deltaSync(): SyncLog
    {
        $log = SyncLog::create([
            'sync_type'  => 'delta',
            'direction'  => 'reconcile',
            'started_at' => now(),
        ]);

        if (! $this->client->isConfigured()) {
            return $this->completeLog($log, 0, 0, 0, 0, [], []);
        }

        // Find last successful sync time
        $lastSync = SyncLog::where('sync_type', 'delta')
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->value('completed_at') ?? now()->subHour();

        $synced = 0;
        $errors = [];

        // Push local changes since last sync
        $changedLocally = User::where('updated_at', '>', $lastSync)
            ->whereNull('deleted_at')
            ->get();

        foreach ($changedLocally as $user) {
            try {
                $this->pushUserToService($user);
                $synced++;
            } catch (\Exception $e) {
                $errors[] = ['pf_number' => $user->pf_number, 'error' => $e->getMessage()];
            }
        }

        // Pull remote changes since last sync
        $response = $this->client->getDelta($lastSync);
        if ($response && ! empty($response['data'])) {
            foreach ($response['data'] as $remoteUser) {
                try {
                    $this->pullUserFromService($remoteUser);
                    $synced++;
                } catch (\Exception $e) {
                    $errors[] = ['pf_number' => $remoteUser['pf_number'] ?? '?', 'error' => $e->getMessage()];
                }
            }
        }

        return $this->completeLog($log, $synced, $synced, 0, count($errors), [], $errors);
    }

    // ── Single user sync ──────────────────────────────────────

    public function syncUser(User $user): array
    {
        if (! $this->client->isConfigured()) {
            return ['outcome' => 'skipped', 'reason' => 'User Service not configured'];
        }

        return $this->pushUserToService($user);
    }

    // ── Push local user → User Service ───────────────────────

    private function pushUserToService(User $user): array
    {
        $payload = [
            'pf_number'     => $user->pf_number,
            'id_number'     => $user->id_number,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'other_names'   => $user->other_names,
            'email'         => $user->email,
            'phone'         => $user->phone,
            'password_hash' => $user->password, // send existing bcrypt hash
            'date_of_birth' => $user->date_of_birth?->format('Y-m-d'),
        ];

        // Already linked — update
        if ($user->user_service_id) {
            $response = $this->client->updateUser($user->user_service_id, $payload);

            if ($response) {
                $user->update([
                    'sync_status'    => 'synced',
                    'sync_direction' => 'linked',
                    'last_synced_at' => now(),
                    'sync_meta'      => null,
                ]);
                return ['outcome' => 'synced'];
            }

            $user->update(['sync_status' => 'pending']);
            return ['outcome' => 'pending', 'reason' => 'User Service unreachable'];
        }

        // Not linked yet — create or find by sync key
        $response = $this->client->createUser($payload);

        if ($response && isset($response['user']['id'])) {
            $remoteUser = $response['user'];

            // Check for conflicts on identity fields
            $conflicts = $this->detectConflicts($user, $remoteUser);

            $user->update([
                'user_service_id' => $remoteUser['id'],
                'sync_status'     => $conflicts ? 'conflict' : 'synced',
                'sync_direction'  => 'linked',
                'last_synced_at'  => now(),
                'sync_meta'       => $conflicts ? ['conflicts' => $conflicts] : null,
            ]);

            if ($conflicts) {
                return ['outcome' => 'conflict', 'detail' => [
                    'pf_number' => $user->pf_number,
                    'conflicts' => $conflicts,
                ]];
            }

            return ['outcome' => 'synced'];
        }

        // User Service down or error
        $user->update(['sync_status' => 'pending']);
        return ['outcome' => 'pending', 'reason' => 'failed to push to User Service'];
    }

    // ── Pull remote user → update local ──────────────────────

    private function pullUserFromService(array $remote): void
    {
        // Find local user by sync key priority: user_service_id > pf > id_number > email
        $local = User::where('user_service_id', $remote['id'])->first()
            ?? User::where('pf_number', $remote['pf_number'])->first()
            ?? ($remote['id_number'] ? User::where('id_number', $remote['id_number'])->first() : null)
            ?? User::where('email', $remote['email'])->first();

        if (! $local) {
            // New user in User Service not yet in FlowDesk
            // Create shadow record — HR will need to assign role/dept
            User::create([
                'user_service_id' => $remote['id'],
                'pf_number'       => $remote['pf_number'],
                'id_number'       => $remote['id_number'],
                'first_name'      => $remote['first_name'],
                'last_name'       => $remote['last_name'],
                'other_names'     => $remote['other_names'],
                'email'           => $remote['email'],
                'phone'           => $remote['phone'],
                'password'        => Hash::make(\Str::random(32)), // placeholder
                'status'          => $remote['status'],
                'pf_number'       => $remote['pf_number'],
                'sync_status'     => 'synced',
                'sync_direction'  => 'linked',
                'last_synced_at'  => now(),
                'force_password_change' => true,
            ]);
            return;
        }

        // Conflict resolution — User Service wins on identity, last_modified wins otherwise
        $remoteUpdated = \Carbon\Carbon::parse($remote['updated_at']);
        $localUpdated  = $local->updated_at;

        $updates = ['user_service_id' => $remote['id'], 'sync_direction' => 'linked'];

        // Identity fields — User Service always wins
        $updates['email']  = $remote['email'];
        $updates['status'] = $remote['status'];

        // Other fields — last_modified wins
        if ($remoteUpdated->gt($localUpdated)) {
            $updates['first_name']  = $remote['first_name'];
            $updates['last_name']   = $remote['last_name'];
            $updates['other_names'] = $remote['other_names'];
            $updates['phone']       = $remote['phone'];
        }

        $updates['sync_status']    = 'synced';
        $updates['last_synced_at'] = now();

        $local->updateQuietly($updates); // updateQuietly = don't update updated_at (avoid sync loop)
    }

    // ── Conflict detection ────────────────────────────────────

    private function detectConflicts(User $local, array $remote): array
    {
        $conflicts = [];

        if ($local->email !== $remote['email']) {
            $conflicts[] = [
                'field'    => 'email',
                'local'    => $local->email,
                'remote'   => $remote['email'],
                'resolved' => 'remote wins (identity field)',
            ];
        }

        return $conflicts;
    }

    // ── Log completion ────────────────────────────────────────

    private function completeLog(
        SyncLog $log, int $total, int $synced,
        int $conflicts, int $errors,
        array $conflictDetails, array $errorDetails
    ): SyncLog {
        $log->update([
            'completed_at'   => now(),
            'total_records'  => $total,
            'synced_count'   => $synced,
            'conflict_count' => $conflicts,
            'error_count'    => $errors,
            'conflicts'      => $conflictDetails ?: null,
            'errors'         => $errorDetails ?: null,
        ]);

        Log::info("Sync completed: {$synced}/{$total} synced, {$conflicts} conflicts, {$errors} errors");

        return $log;
    }
}
