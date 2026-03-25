<?php

namespace App\Livewire\Oversight;

use App\Models\ApplicationLog;
use App\Models\AuthLog;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AuditTrail extends Component
{
    use WithPagination;

    public string $tab          = 'applications';
    public string $search       = '';
    public string $filterAction = '';
    public string $filterUser   = '';
    public string $dateFrom     = '';
    public string $dateTo       = '';

    protected $paginationTheme = 'bootstrap';

    public function updatingTab(): void    { $this->resetPage(); }
    public function updatingSearch(): void { $this->resetPage(); }

    public function render()
    {
        if ($this->tab === 'applications') {
            $logs = ApplicationLog::query()
                ->with(['user', 'application'])
                ->when($this->search, fn($q) =>
                    $q->where('action', 'ilike', "%{$this->search}%")
                      ->orWhere('description', 'ilike', "%{$this->search}%")
                      ->orWhereHas('user', fn($u) =>
                          $u->where('first_name', 'ilike', "%{$this->search}%")
                            ->orWhere('last_name',  'ilike', "%{$this->search}%")
                      )
                )
                ->when($this->filterAction, fn($q) => $q->where('action', $this->filterAction))
                ->when($this->filterUser,   fn($q) => $q->where('user_id', $this->filterUser))
                ->when($this->dateFrom,     fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
                ->when($this->dateTo,       fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
                ->latest()
                ->paginate(20);

            $actions = ApplicationLog::distinct()->orderBy('action')->pluck('action');

        } else {
            $logs = AuthLog::query()
                ->with('user')
                ->when($this->search, fn($q) =>
                    $q->whereHas('user', fn($u) =>
                        $u->where('first_name', 'ilike', "%{$this->search}%")
                          ->orWhere('last_name',  'ilike', "%{$this->search}%")
                          ->orWhere('email',      'ilike', "%{$this->search}%")
                    )->orWhere('ip_address', 'ilike', "%{$this->search}%")
                )
                ->when($this->filterAction, fn($q) => $q->where('action', $this->filterAction))
                ->when($this->dateFrom,     fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
                ->when($this->dateTo,       fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
                ->latest()
                ->paginate(20);

            $actions = AuthLog::distinct()->orderBy('action')->pluck('action');
        }

        $users = User::orderBy('first_name')->get(['id', 'first_name', 'last_name']);

        return view('livewire.oversight.audit-trail',
            compact('logs', 'actions', 'users'))
            ->layout('components.layouts.app');
    }
}
