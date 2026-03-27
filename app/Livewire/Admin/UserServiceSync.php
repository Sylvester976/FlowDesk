<?php

namespace App\Livewire\Admin;

use App\Models\SyncLog;
use App\Models\User;
use App\Services\SyncService;
use App\Services\UserServiceClient;
use Livewire\Component;
use Livewire\WithPagination;

class UserServiceSync extends Component
{
    use WithPagination;

    public bool   $isHealthy    = false;
    public bool   $isConfigured = false;
    public bool   $syncing      = false;
    public string $filterStatus = 'all';

    protected $paginationTheme = 'bootstrap';

    public function mount(UserServiceClient $client): void
    {
        $this->isConfigured = $client->isConfigured();
        $this->isHealthy    = $this->isConfigured && $client->isHealthy();
    }

    public function runFullSync(SyncService $sync): void
    {
        if (! $this->isHealthy) {
            $this->dispatch('notify', type: 'error', message: 'User Service is not reachable.');
            return;
        }

        $this->syncing = true;
        $log = $sync->fullSync(auth()->id());
        $this->syncing = false;

        $this->dispatch('notify', type: 'success',
            message: "Sync complete: {$log->synced_count} synced, {$log->conflict_count} conflicts, {$log->error_count} errors.");
    }

    public function runDeltaSync(SyncService $sync): void
    {
        if (! $this->isHealthy) {
            $this->dispatch('notify', type: 'error', message: 'User Service is not reachable.');
            return;
        }

        $log = $sync->deltaSync();
        $this->dispatch('notify', type: 'success',
            message: "Delta sync complete: {$log->synced_count} updated.");
    }

    public function syncUser(int $userId, SyncService $sync): void
    {
        $user   = User::findOrFail($userId);
        $result = $sync->syncUser($user);

        $this->dispatch('notify',
            type: $result['outcome'] === 'synced' ? 'success' : 'warning',
            message: "Sync {$result['outcome']} for {$user->full_name}."
        );
    }

    public function render(UserServiceClient $client)
    {
        // Summary counts
        $summary = [
            'total'    => User::whereNull('deleted_at')->count(),
            'synced'   => User::where('sync_status', 'synced')->count(),
            'pending'  => User::where('sync_status', 'pending')->count(),
            'unlinked' => User::whereNull('user_service_id')->count(),
            'conflict' => User::where('sync_status', 'conflict')->count(),
        ];

        // Staff list filtered by sync status
        $staff = User::query()
            ->whereNull('deleted_at')
            ->when($this->filterStatus !== 'all', fn($q) =>
                $q->where('sync_status', $this->filterStatus)
            )
            ->when($this->filterStatus === 'unlinked', fn($q) =>
                $q->whereNull('user_service_id')
            )
            ->with('role')
            ->orderBy('sync_status')
            ->orderBy('last_name')
            ->paginate(20);

        // Recent sync logs
        $logs = SyncLog::latest()->limit(10)->get();

        return view('livewire.admin.user-service-sync',
            compact('summary', 'staff', 'logs'))
            ->layout('components.layouts.app');
    }
}
