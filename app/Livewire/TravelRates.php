<?php

namespace App\Livewire;

use App\Models\TravelRate;
use Livewire\Component;
use Livewire\WithPagination;

class TravelRates extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $filterType  = '';

    // Form
    public bool   $showForm    = false;
    public ?int   $editId      = null;
    public string $category    = '';
    public string $destination = '';
    public string $rate_type   = 'per_diem';
    public string $amount      = '';
    public string $currency    = 'USD';
    public string $description = '';
    public bool   $is_active   = true;

    protected $paginationTheme = 'bootstrap';

    protected $messages = [
        'category.required'    => 'Category is required.',
        'destination.required' => 'Destination/country group is required.',
        'amount.required'      => 'Amount is required.',
        'amount.numeric'       => 'Amount must be a number.',
        'amount.min'           => 'Amount must be greater than 0.',
    ];

    public function updatingSearch(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->reset(['editId', 'category', 'destination', 'amount',
            'description', 'currency']);
        $this->rate_type = 'per_diem';
        $this->currency  = 'USD';
        $this->is_active = true;
        $this->showForm  = true;
    }

    public function openEdit(int $id): void
    {
        $rate = TravelRate::findOrFail($id);

        $this->editId      = $id;
        $this->category    = $rate->category;
        $this->destination = $rate->destination;
        $this->rate_type   = $rate->rate_type;
        $this->amount      = (string) $rate->amount;
        $this->currency    = $rate->currency;
        $this->description = $rate->description ?? '';
        $this->is_active   = $rate->is_active;
        $this->showForm    = true;
    }

    public function save(): void
    {
        $this->validate([
            'category'    => ['required', 'string', 'max:100'],
            'destination' => ['required', 'string', 'max:200'],
            'rate_type'   => ['required', 'in:per_diem,accommodation,transport,incidental'],
            'amount'      => ['required', 'numeric', 'min:0.01'],
            'currency'    => ['required', 'string', 'size:3'],
            'description' => ['nullable', 'string', 'max:300'],
        ]);

        $data = [
            'category'    => $this->category,
            'destination' => $this->destination,
            'rate_type'   => $this->rate_type,
            'amount'      => $this->amount,
            'currency'    => strtoupper($this->currency),
            'description' => $this->description ?: null,
            'is_active'   => $this->is_active,
            'updated_by'  => auth()->id(),
        ];

        if ($this->editId) {
            TravelRate::findOrFail($this->editId)->update($data);
            $msg = 'Travel rate updated.';
        } else {
            TravelRate::create(array_merge($data, ['created_by' => auth()->id()]));
            $msg = 'Travel rate added.';
        }

        $this->showForm = false;
        $this->dispatch('notify', type: 'success', message: $msg);
    }

    public function toggleActive(int $id): void
    {
        $rate = TravelRate::findOrFail($id);
        $rate->update(['is_active' => ! $rate->is_active]);
        $this->dispatch('notify', type: 'success',
            message: 'Rate ' . ($rate->is_active ? 'deactivated' : 'activated') . '.');
    }

    public function delete(int $id): void
    {
        TravelRate::findOrFail($id)->delete(); // hard delete — no soft deletes on this model
        $this->dispatch('notify', type: 'success', message: 'Travel rate deleted.');
    }

    public function render()
    {
        $rates = TravelRate::query()
            ->when($this->search, fn($q) =>
                $q->where('destination', 'ilike', "%{$this->search}%")
                  ->orWhere('category', 'ilike', "%{$this->search}%")
            )
            ->when($this->filterType, fn($q) => $q->where('rate_type', $this->filterType))
            ->orderBy('destination')
            ->orderBy('rate_type')
            ->paginate(15);

        $canManage = auth()->user()->canManageUsers();

        return view('livewire.travel-rates', compact('rates', 'canManage'))
            ->layout('components.layouts.app');
    }
}
