<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\VerifyOtp;
use Illuminate\Support\Facades\Route;

// ============================================================
// Guest routes
// ============================================================
Route::middleware('guest')->group(function () {

    Route::get('/login', Login::class)->name('login');
    Route::get('/otp', VerifyOtp::class)->name('auth.otp');

    // Password reset (standard Laravel — we add later)
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))
        ->name('password.request');
});

// ============================================================
// Authenticated routes
// ============================================================
Route::middleware(['auth'])->group(function () {

    // Root redirect
    Route::get('/', fn() => redirect()->route('dashboard'));

    // Logout
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

    // Role dashboards (Livewire components — added as we build each)
    Route::get('/dashboard/staff',      fn() => view('dashboard.staff'))->name('dashboard.staff');
    Route::get('/dashboard/supervisor', fn() => view('dashboard.supervisor'))->name('dashboard.supervisor');
    Route::get('/dashboard/hr',         fn() => view('dashboard.hr'))->name('dashboard.hr');
    Route::get('/dashboard/ps',         fn() => view('dashboard.ps'))->name('dashboard.ps');

    // Profile
    Route::get('/profile', fn() => view('profile.edit'))->name('profile.edit');

    // --------------------------------------------------------
    // Travel applications
    // --------------------------------------------------------
    Route::prefix('travel')->name('travel.')->group(function () {
        Route::get('/',          fn() => view('travel.index'))->name('index');
        Route::get('/apply',     fn() => view('travel.create'))->name('create');
        Route::get('/rates',     fn() => view('travel.rates'))->name('rates');
        Route::get('/post-trip', fn() => view('travel.post-trip'))->name('post-trip');
        Route::get('/concurrence', fn() => view('travel.concurrence'))->name('concurrence');
    });

    // --------------------------------------------------------
    // Oversight (PS / Superadmin)
    // --------------------------------------------------------
    Route::prefix('oversight')->name('oversight.')->group(function () {
        Route::get('/applications', fn() => view('oversight.all-applications'))->name('all-applications');
        Route::get('/out-of-office', fn() => view('oversight.out-of-office'))->name('out-of-office');
        Route::get('/docket',       fn() => view('oversight.docket'))->name('docket');
    });

    // --------------------------------------------------------
    // Admin
    // --------------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/staff',        fn() => view('admin.staff.index'))->name('staff.index');
        Route::get('/org',          fn() => view('admin.org.index'))->name('org.index');
        Route::get('/roles',        fn() => view('admin.roles.index'))->name('roles.index');
    });

});
