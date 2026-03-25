<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\VerifyOtp;
use App\Livewire\Auth\ChangePassword;
use App\Livewire\Admin\StaffList;
use App\Livewire\Admin\CreateStaff;
use App\Livewire\Admin\RolesManager;
use App\Livewire\Admin\OrgStructureManager;
use App\Livewire\Admin\EditStaff;
use Illuminate\Support\Facades\Route;
use App\Livewire\Travel\TravelWizard;
use App\Livewire\Travel\MyApplications;
use App\Livewire\Travel\ApplicationDetail;
use App\Http\Controllers\DocumentController;
use App\Livewire\AllNotifications;
use App\Livewire\Travel\ConcurrenceQueue;
use App\Livewire\Travel\EditApplication;
use App\Http\Controllers\ClearanceLetterController;



// ============================================================
// Guest routes
// ============================================================
Route::middleware('guest')->group(function () {

    Route::get('/login', Login::class)->name('login');
    Route::get('/otp', VerifyOtp::class)->name('auth.otp');

    Route::get('/forgot-password', fn() => view('auth.forgot-password'))
        ->name('password.request');
});

// ============================================================
// Authenticated routes
// ============================================================
Route::middleware(['auth'])->group(function () {

    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::get('/password/change', ChangePassword::class)->name('password.change');

    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    // Dashboard — role-aware redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->isSuperAdmin() || $user->isPS()) {
            return redirect()->route('dashboard.ps');
        }
        if ($user->isHR()) {
            return redirect()->route('dashboard.hr');
        }
        if ($user->isSupervisor()) {
            return redirect()->route('dashboard.supervisor');
        }
        return redirect()->route('dashboard.staff');

    })->name('dashboard');

    Route::get('/dashboard/staff',      fn() => view('dashboard.staff'))->name('dashboard.staff');
    Route::get('/dashboard/supervisor', fn() => view('dashboard.supervisor'))->name('dashboard.supervisor');
    Route::get('/dashboard/hr',         fn() => view('dashboard.hr'))->name('dashboard.hr');
    Route::get('/dashboard/ps',         fn() => view('dashboard.ps'))->name('dashboard.ps');

    Route::get('/profile', fn() => view('profile.edit'))->name('profile.edit');

    // --------------------------------------------------------
    // Travel applications
    // --------------------------------------------------------
    Route::prefix('travel')->name('travel.')->group(function () {
        Route::get('/',            MyApplications::class)->name('index');
        Route::get('/apply',       TravelWizard::class)->name('create');
        Route::get('/rates',       fn() => view('travel.rates'))->name('rates');
        Route::get('/post-trip',   fn() => view('travel.post-trip'))->name('post-trip');
        Route::get('/concurrence', ConcurrenceQueue::class)->name('concurrence');
        Route::get('/document/{document}',       [DocumentController::class, 'show'])->name('document');
        Route::get('/clearance/{application}',   [ClearanceLetterController::class, 'show'])->name('clearance');
        Route::get('/{application}/edit',        EditApplication::class)->name('edit');
        Route::get('/{application}',             ApplicationDetail::class)->name('show');
    });

    // --------------------------------------------------------
    // Oversight (PS / Superadmin)
    // --------------------------------------------------------
    Route::prefix('oversight')->name('oversight.')->group(function () {
        Route::get('/applications',  fn() => view('oversight.all-applications'))->name('all-applications');
        Route::get('/out-of-office', fn() => view('oversight.out-of-office'))->name('out-of-office');
        Route::get('/docket',        fn() => view('oversight.docket'))->name('docket');
    });

    // --------------------------------------------------------
    // Admin & HR
    // --------------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/staff',             StaffList::class)->name('staff.index');
        Route::get('/staff/create',      CreateStaff::class)->name('staff.create');
        Route::get('/staff/{user}/edit', EditStaff::class)->name('staff.edit');

        Route::get('/org',   OrgStructureManager::class)->name('org.index');
        Route::get('/roles', RolesManager::class)->name('roles.index');
    });

    // --------------------------------------------------------
    // Notifications
    // --------------------------------------------------------
    Route::get('/notifications', AllNotifications::class)->name('notifications.index');
});
