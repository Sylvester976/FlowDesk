<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserServiceWebhookController extends Controller
{
    /**
     * Verify webhook signature from User Service.
     * User Service sends X-Webhook-Key header with the shared API key.
     */
    private function verifyWebhook(Request $request): bool
    {
        $key = $request->header('X-Webhook-Key');
        return $key === config('services.user_service.api_key');
    }

    /**
     * POST /api/webhook/user-service
     * Receives events: user.created, user.updated, user.deactivated, user.activated
     */
    public function handle(Request $request)
    {
        if (! $this->verifyWebhook($request)) {
            Log::warning('User Service webhook: invalid key from ' . $request->ip());
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $event   = $request->input('event');
        $payload = $request->input('user');

        if (! $event || ! $payload) {
            return response()->json(['error' => 'Missing event or user payload'], 422);
        }

        Log::info("User Service webhook received: {$event} for PF: " . ($payload['pf_number'] ?? '?'));

        match ($event) {
            'user.created'     => $this->onUserCreated($payload),
            'user.updated'     => $this->onUserUpdated($payload),
            'user.deactivated' => $this->onUserDeactivated($payload),
            'user.activated'   => $this->onUserActivated($payload),
            default            => Log::info("User Service webhook: unknown event {$event}"),
        };

        return response()->json(['status' => 'received']);
    }

    private function onUserCreated(array $payload): void
    {
        // Find or create local shadow record
        $local = $this->findLocal($payload);

        if ($local) {
            // Already exists — just link it
            $local->updateQuietly([
                'user_service_id' => $payload['id'],
                'sync_status'     => 'synced',
                'sync_direction'  => 'linked',
                'last_synced_at'  => now(),
            ]);
            return;
        }

        // New user — create shadow record
        // HR will need to assign role and department
        User::create([
            'user_service_id'       => $payload['id'],
            'pf_number'             => $payload['pf_number'],
            'id_number'             => $payload['id_number'],
            'first_name'            => $payload['first_name'],
            'last_name'             => $payload['last_name'],
            'other_names'           => $payload['other_names'] ?? null,
            'email'                 => $payload['email'],
            'phone'                 => $payload['phone'] ?? null,
            'password'              => \Hash::make(\Str::random(32)), // placeholder
            'status'                => 'active',
            'force_password_change' => true,
            'sync_status'           => 'synced',
            'sync_direction'        => 'linked',
            'last_synced_at'        => now(),
        ]);
    }

    private function onUserUpdated(array $payload): void
    {
        $local = $this->findLocal($payload);
        if (! $local) return;

        $local->updateQuietly([
            'first_name'      => $payload['first_name'],
            'last_name'       => $payload['last_name'],
            'other_names'     => $payload['other_names'] ?? null,
            'email'           => $payload['email'],
            'phone'           => $payload['phone'] ?? null,
            'user_service_id' => $payload['id'],
            'sync_status'     => 'synced',
            'last_synced_at'  => now(),
        ]);
    }

    private function onUserDeactivated(array $payload): void
    {
        $systems = $payload['systems'] ?? []; // empty = global

        $local = $this->findLocal($payload);
        if (! $local) return;

        // Global deactivation OR FlowDesk is in the systems list
        if (empty($systems) || in_array('flowdesk', $systems)) {
            $local->updateQuietly([
                'status'          => 'inactive',
                'sync_status'     => 'synced',
                'last_synced_at'  => now(),
            ]);

            Log::info("User {$local->pf_number} deactivated via User Service webhook.");
        }
    }

    private function onUserActivated(array $payload): void
    {
        $local = $this->findLocal($payload);
        if (! $local) return;

        $local->updateQuietly([
            'status'         => 'active',
            'sync_status'    => 'synced',
            'last_synced_at' => now(),
        ]);
    }

    private function findLocal(array $payload): ?User
    {
        return User::where('user_service_id', $payload['id'])->first()
            ?? User::where('pf_number', $payload['pf_number'])->first()
            ?? (isset($payload['id_number']) ? User::where('id_number', $payload['id_number'])->first() : null)
            ?? User::where('email', $payload['email'])->first();
    }
}
