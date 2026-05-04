<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});
 
// Patient dashboard — only accessible by patients
Route::get('/dashboard', function () {
    return view('patient.index');
})->middleware(['auth', 'patient'])->name('dashboard');

// Doctor dashboard — only accessible by doctors
Route::get('/doctor/dashboard', [DoctorController::class, 'DoctorDashboard'])
    ->middleware(['auth', 'doctor'])
    ->name('doctor.dashboard');

// Admin routes
Route::get('/agent/login', [AdminController::class, 'AdminLogin'])
    ->name('agent.login');

Route::post('/agent/login', [AdminController::class, 'AdminLoginPost'])
    ->name('agent.login.post');

Route::post('/agent/logout', [AdminController::class, 'AdminLogout'])
    ->name('agent.logout');

 

Route::middleware(['admin'])->controller(AdminController::class)->group(function () {

Route::get('/agent/dashboard', 'AdminDashboard')->name('agent.dashboard');

Route::get('/agent/spcialities', 'AdminSpcialities')->name('agent.spcialities');
       

    });
    /// End Admin Group Middleware 


// Shared logout (works for both roles via the auth guard)
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
