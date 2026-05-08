<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SpecialityController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/doctor/details/{id}', [FrontendController::class, 'DoctorDetails'])->name('doctor.details');

Route::get('/doctor/booking/{id}', [FrontendController::class, 'DoctorBooking'])->name('doctor.booking');

// Booking POST — patient only
Route::post('/doctor/booking/{id}', [AppointmentController::class, 'store'])
    ->middleware(['auth', 'patient'])
    ->name('appointment.store');

// Appointment success confirmation
Route::get('/appointment/success/{appointmentNumber}', [AppointmentController::class, 'success'])
    ->middleware(['auth', 'patient'])
    ->name('appointment.success');

// AJAX: load available slots (public — no auth needed)
Route::get('/ajax/slots/{doctorId}', [AppointmentController::class, 'loadSlots'])
    ->name('appointment.slots');

// Favourite toggle (AJAX — patient only, no extra middleware; controller checks role)
Route::post('/favourite/toggle/{doctorId}', [FavouriteController::class, 'toggle'])
    ->name('favourite.toggle');

// Print invoice
Route::get('/invoice/print/{appointmentNumber}', [AppointmentController::class, 'printInvoice'])
    ->middleware(['auth', 'patient'])
    ->name('invoice.print');
 
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



Route::middleware(['auth', 'patient'])->group(function () {

Route::get('/patient/setting', [PatientController::class, 'PatientSetting'])->name('patient.setting');
Route::post('/patient/setting', [PatientController::class, 'PatientSettingPost'])->name('patient.setting.post');

Route::get('/patient/change/password', [PatientController::class, 'PatientChangePassword'])->name('patient.change.password');
Route::post('/patient/change/password', [PatientController::class, 'PatientChangePasswordPost'])->name('patient.change.password.post');


Route::get('/patient/appointments', [PatientController::class, 'PatientAppointments'])->name('patient.appointments');

Route::get('/patient/invoices', [PatientController::class, 'PatientInvoices'])->name('patient.invoices');

Route::get('/patient/favourites', [PatientController::class, 'PatientFavourites'])->name('patient.favourites');


Route::get('/patient/medical/records', [PatientController::class, 'PatientMedicalRecords'])->name('patient.medical.records');


  });
/// End Patient Group Middleware
 

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

Route::get('/doctor/change/password', [DoctorController::class, 'DoctorChangePassword'])->name('doctor.change.password');
Route::post('/doctor/change/password', [DoctorController::class, 'DoctorChangePasswordPost'])->name('doctor.change.password.post');


Route::get('/doctor/requests', [DoctorController::class, 'DoctorRequests'])->name('doctor.requests');
Route::post('/doctor/appointments/{id}/status', [DoctorController::class, 'DoctorAppointmentStatus'])->name('doctor.appointment.status');



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
