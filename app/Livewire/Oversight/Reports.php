<?php

namespace App\Livewire\Oversight;

use App\Models\TravelApplication;
use Livewire\Component;

class Reports extends Component
{
    public string $appYear    = '';
    public string $appStatus  = '';
    public string $appType    = '';
    public string $summaryYear = '';
    public string $docketYear  = '';

    public function mount(): void
    {
        $this->appYear     = (string) now()->year;
        $this->summaryYear = (string) now()->year;
        $this->docketYear  = (string) now()->year;
    }

    public function render()
    {
        $years = TravelApplication::selectRaw(
            'extract(year from created_at)::int as yr'
        )->groupBy('yr')->orderByDesc('yr')->pluck('yr');

        return view('livewire.oversight.reports', compact('years'))
            ->layout('components.layouts.app');
    }
}
