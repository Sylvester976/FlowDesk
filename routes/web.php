<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\VerifyOtp;
use App\Livewire\Auth\ChangePassword;
use App\Livewire\Admin\StaffList;
use App\Livewire\Admin\CreateStaff;
use App\Livewire\Admin\RolesManager;
use App\Livewire\Admin\OrgStructureManager;
use App\Livewire\Admin\EditStaff;
use App\Livewire\AllNotifications;
use App\Livewire\ProfileEdit;
use App\Livewire\TravelRates;
use App\Livewire\Travel\TravelWizard;
use App\Livewire\Travel\MyApplications;
use App\Livewire\Travel\ApplicationDetail;
use App\Livewire\Travel\ConcurrenceQueue;
use App\Livewire\Travel\EditApplication;
use App\Livewire\Travel\PostTripUpload;
use App\Livewire\Travel\PostTripReview;
use App\Livewire\Dashboard\StaffDashboard;
use App\Livewire\Dashboard\SupervisorDashboard;
use App\Livewire\Dashboard\HRDashboard;
use App\Livewire\Dashboard\PSDashboard;
use App\Livewire\Oversight\AllApplications;
use App\Livewire\Oversight\OutOfOffice;
use App\Livewire\Oversight\DaysDocket;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ClearanceLetterController;
use Illuminate\Support\Facades\Route;

// ============================================================
// Guest routes
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login',           Login::class)->name('login');
    Route::get('/otp',             VerifyOtp::class)->name('auth.otp');
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
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

    // --------------------------------------------------------
    // Dashboard
    // --------------------------------------------------------
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isSuperAdmin() || $user->isPS()) return redirect()->route('dashboard.ps');
        if ($user->isHR())                           return redirect()->route('dashboard.hr');
        if ($user->isSupervisor())                   return redirect()->route('dashboard.supervisor');
        return redirect()->route('dashboard.staff');
    })->name('dashboard');

    Route::get('/dashboard/staff',      StaffDashboard::class)->name('dashboard.staff');
    Route::get('/dashboard/supervisor', SupervisorDashboard::class)->name('dashboard.supervisor');
    Route::get('/dashboard/hr',         HRDashboard::class)->name('dashboard.hr');
    Route::get('/dashboard/ps',         PSDashboard::class)->name('dashboard.ps');

    // --------------------------------------------------------
    // Profile & Notifications
    // --------------------------------------------------------
    Route::get('/profile',       ProfileEdit::class)->name('profile.edit');
    Route::get('/notifications', AllNotifications::class)->name('notifications.index');

    // --------------------------------------------------------
    // Travel applications
    // --------------------------------------------------------
    Route::prefix('travel')->name('travel.')->group(function () {
        Route::get('/',                 MyApplications::class)->name('index');
        Route::get('/apply',            TravelWizard::class)->name('create');
        Route::get('/rates',            TravelRates::class)->name('rates');
        Route::get('/post-trip',        PostTripUpload::class)->name('post-trip');
        Route::get('/post-trip-review', PostTripReview::class)->name('post-trip-review');
        Route::get('/concurrence',      ConcurrenceQueue::class)->name('concurrence');

        Route::get('/document/{document}',     [DocumentController::class, 'show'])->name('document');
        Route::get('/clearance/{application}', [ClearanceLetterController::class, 'show'])->name('clearance');
        Route::get('/{application}/edit',      EditApplication::class)->name('edit');

        // Must be last — wildcard
        Route::get('/{application}', ApplicationDetail::class)->name('show');
    });

    // --------------------------------------------------------
    // Oversight (PS / HR / Superadmin)
    // --------------------------------------------------------
    Route::prefix('oversight')->name('oversight.')->group(function () {
        Route::get('/applications',  AllApplications::class)->name('all-applications');
        Route::get('/out-of-office', OutOfOffice::class)->name('out-of-office');
        Route::get('/docket',        DaysDocket::class)->name('docket');
    });

    // --------------------------------------------------------
    // Administration (HR / Superadmin)
    // --------------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/staff',             StaffList::class)->name('staff.index');
        Route::get('/staff/create',      CreateStaff::class)->name('staff.create');
        Route::get('/staff/{user}/edit', EditStaff::class)->name('staff.edit');
        Route::get('/org',               OrgStructureManager::class)->name('org.index');
        Route::get('/roles',             RolesManager::class)->name('roles.index');
    });
});
