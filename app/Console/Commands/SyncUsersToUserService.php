<?php

namespace App\Console\Commands;

use App\Services\SyncService;
use App\Services\UserServiceClient;
use App\Models\User;
use Illuminate\Console\Command;

// ── Full sync ─────────────────────────────────────────────────

class SyncUsersToUserService extends Command
{
    protected $signature   = 'users:sync {--user= : Sync a single user by PF number}
                                          {--pending : Only sync pending users}
                                          {--full : Full sync both directions}
                                          {--delta : Delta sync (changes since last sync)}';
    protected $description = 'Sync FlowDesk users with User Service';

    public function handle(SyncService $sync, UserServiceClient $client): int
    {
        if (! $client->isConfigured()) {
            $this->warn('User Service is not configured. Set USER_SERVICE_URL and USER_SERVICE_API_KEY in .env');
            return self::FAILURE;
        }

        if (! $client->isHealthy()) {
            $this->error('User Service is unreachable. Check connectivity.');
            return self::FAILURE;
        }

        // Single user
        if ($pf = $this->option('user')) {
            return $this->syncSingleUser($pf, $sync);
        }

        // Delta sync
        if ($this->option('delta')) {
            $this->info('Running delta sync...');
            $log = $sync->deltaSync();
            $this->displayLogResult($log);
            return self::SUCCESS;
        }

        // Pending only
        if ($this->option('pending')) {
            return $this->syncPending($sync);
        }

        // Full sync (default)
        $this->info('Running full bidirectional sync...');
        $this->warn('This may take a while for large user bases.');

        $log = $sync->fullSync(auth()->id());
        $this->displayLogResult($log);

        return self::SUCCESS;
    }

    private function syncSingleUser(string $pf, SyncService $sync): int
    {
        $user = User::where('pf_number', $pf)->first();
        if (! $user) {
            $this->error("User with PF number {$pf} not found.");
            return self::FAILURE;
        }

        $this->info("Syncing {$user->full_name} (PF: {$pf})...");
        $result = $sync->syncUser($user);

        match ($result['outcome']) {
            'synced'  => $this->info("✓ Synced. User Service ID: {$user->fresh()->user_service_id}"),
            'pending' => $this->warn("⚠ Pending: " . ($result['reason'] ?? '')),
            'conflict' => $this->warn("⚠ Conflict detected: " . json_encode($result['detail'] ?? [])),
            default   => $this->line("Result: " . json_encode($result)),
        };

        return self::SUCCESS;
    }

    private function syncPending(SyncService $sync): int
    {
        $pending = User::where('sync_status', 'pending')->orWhereNull('user_service_id')->get();

        if ($pending->isEmpty()) {
            $this->info('No pending users to sync.');
            return self::SUCCESS;
        }

        $this->info("Syncing {$pending->count()} pending users...");
        $bar = $this->output->createProgressBar($pending->count());
        $bar->start();

        $synced = 0;
        foreach ($pending as $user) {
            $result = $sync->syncUser($user);
            if ($result['outcome'] === 'synced') $synced++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Synced: {$synced}/{$pending->count()}");

        return self::SUCCESS;
    }

    private function displayLogResult($log): void
    {
        $this->newLine();
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Records',   $log->total_records],
                ['Synced',          $log->synced_count],
                ['Skipped',         $log->skipped_count],
                ['Conflicts',       $log->conflict_count],
                ['Errors',          $log->error_count],
                ['Duration',        $log->duration],
            ]
        );

        if ($log->conflict_count > 0) {
            $this->warn("{$log->conflict_count} conflicts found. Review sync log ID: {$log->id}");
        }
        if ($log->error_count > 0) {
            $this->error("{$log->error_count} errors. Review sync log ID: {$log->id}");
        }
    }
}
