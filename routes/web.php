<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard-staff', [DashboardController::class, 'dashboardStaff'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard-staff');

Route::get('/dashboard-ict', [DashboardController::class, 'dashboardIct'])
    ->middleware(['auth', 'verified'])
    ->name('ddashboard-ict');

Route::get('/dashboard-hr', [DashboardController::class, 'dashboardHr'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard-hr');

Route::get('/employees', [UserController::class, 'showAllEmployees'])
    ->middleware(['auth', 'verified'])
    ->name('employees');

Route::get('/employee_add', [UserController::class, 'addEmployee'])
    ->middleware(['auth', 'verified'])
    ->name('employee_add');

Route::post('/save_staff', [DashboardController::class, 'save_staff'])
    ->middleware(['auth', 'verified'])
    ->name('save_staff');

Route::get('/assignment_add', [DashboardController::class, 'assignmentAdd'])
    ->middleware(['auth', 'verified'])
    ->name('assignment_add');
Route::get('/subcounties/{county}', [DashboardController::class, 'getSubcounties']);
Route::post('/save_assignment', [DashboardController::class, 'save_assignment'])
    ->middleware(['auth', 'verified'])
    ->name('save_assignment');
Route::get('/assignHistory', [DashboardController::class, 'assign_history'])
    ->middleware(['auth', 'verified'])
    ->name('assignHistory');
Route::get('/activeAssignment', [DashboardController::class, 'activeAssignment'])
    ->middleware(['auth', 'verified'])
    ->name('activeAssignment');
Route::get('/assignmentHistory', [DashboardController::class, 'assignmentHistory'])
    ->middleware(['auth', 'verified'])
    ->name('assignmentHistory');
Route::get('/viewAssignmentHistory/{id}', [DashboardController::class, 'viewAssignmentHistory'])
    ->name('view.assignment');
Route::get('/create_assignment', [DashboardController::class, 'create_assignment'])
    ->middleware(['auth', 'verified'])
    ->name('create_assignment');
Route::post('/save_assignment_admin', [DashboardController::class, 'save_assignment_admin'])
    ->middleware(['auth', 'verified'])
    ->name('save_assignment_admin');

// Aviation stack API
Route::get('/airports/{countryCode}', [DashboardController::class, 'getAirports']);





require __DIR__.'/auth.php';
