<div>
<div class="main-content">
    <div class="page-header">
        <div>
            <h1 class="page-title">Add Staff Member</h1>
            <nav class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">Home</a>
                <a href="{{ route('admin.staff.index') }}" class="breadcrumb-item">Staff</a>
                <span class="breadcrumb-item active">Add</span>
            </nav>
        </div>
    </div>

    <form wire:submit="save" novalidate>
        @include('livewire.admin._staff-form', ['isEdit' => false])
    </form>
</div>
</div>
