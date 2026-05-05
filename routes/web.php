<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SpecialityController;
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


 

Route::middleware(['auth', 'doctor'])->group(function () {

Route::get('/doctor/profile', [DoctorController::class, 'DoctorProfile'])->name('doctor.profile');
Route::post('/doctor/profile', [DoctorController::class, 'DoctorProfilePost'])->name('doctor.profile.post');

Route::get('/doctor/experience', [DoctorController::class, 'DoctorExperience'])->name('doctor.experience');
Route::post('/doctor/experience', [DoctorController::class, 'DoctorExperiencePost'])->name('doctor.experience.post');

Route::get('/doctor/education', [DoctorController::class, 'DoctorEducation'])->name('doctor.education');
Route::post('/doctor/education', [DoctorController::class, 'DoctorEducationPost'])->name('doctor.education.post');

Route::get('/doctor/clinics', [DoctorController::class, 'DoctorClinics'])->name('doctor.clinics');
Route::post('/doctor/clinics', [DoctorController::class, 'DoctorClinicsPost'])->name('doctor.clinics.post');

Route::get('/doctor/hours', [DoctorController::class, 'DoctorHours'])->name('doctor.hours');
Route::post('/doctor/hours', [DoctorController::class, 'DoctorHoursPost'])->name('doctor.hours.post');
   
Route::get('/specialities/services', [DoctorController::class, 'SpecialitiesServices'])->name('specialities.services');
Route::post('/specialities/services', [DoctorController::class, 'SpecialitiesServicesPost'])->name('specialities.services.post');


});
/// End Doctor Group Middleware

 

Route::middleware(['admin'])->group(function () {

    Route::get('/agent/dashboard', [AdminController::class, 'AdminDashboard'])->name('agent.dashboard');

    // Specialities CRUD
    Route::get('/agent/spcialities', [SpecialityController::class, 'index'])->name('agent.spcialities');
    Route::post('/agent/spcialities', [SpecialityController::class, 'store'])->name('agent.spcialities.store');
    Route::put('/agent/spcialities/{id}', [SpecialityController::class, 'update'])->name('agent.spcialities.update');
    Route::delete('/agent/spcialities/{id}', [SpecialityController::class, 'destroy'])->name('agent.spcialities.destroy');

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
