<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class AllNotifications extends Component
{
    use WithPagination;

    public string $filter = 'all';

    protected $paginationTheme = 'bootstrap';

    public function markAllRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->dispatch('notify', type: 'success', message: 'All notifications marked as read.');
    }

    public function markRead(string $id): void
    {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
    }

    public function render()
    {
        $notifications = auth()->user()
            ->notifications()
            ->when($this->filter === 'unread', fn($q) => $q->whereNull('read_at'))
            ->latest()
            ->paginate(15);

        $unreadCount = auth()->user()->unreadNotifications()->count();

        return view('livewire.all-notifications', compact('notifications', 'unreadCount'))
            ->layout('components.layouts.app');
    }
}
