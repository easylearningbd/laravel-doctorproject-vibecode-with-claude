<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'profile_photo',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        // Patient-only
        'date_of_birth',
        'blood_group',
        // Doctor-only
        'display_name',
        'designation',
        'specialization',
        'known_languages',
        'is_available',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'date_of_birth'     => 'date',
            'is_available'      => 'boolean',
            'known_languages'   => 'array',
        ];
    }

    public function memberships()
    {
        return $this->hasMany(DoctorMembership::class, 'user_id');
    }

    public function experiences()
    {
        return $this->hasMany(DoctorExperience::class, 'user_id');
    }

    public function educations()
    {
        return $this->hasMany(DoctorEducation::class, 'user_id');
    }

    public function clinics()
    {
        return $this->hasMany(DoctorClinic::class, 'user_id');
    }

    public function businessHours()
    {
        return $this->hasMany(DoctorBusinessHour::class, 'user_id');
    }

    public function specialityServices()
    {
        return $this->hasMany(DoctorSpecialityService::class, 'user_id');
    }

    public function favouriteDoctors()
    {
        return $this->belongsToMany(
            User::class,
            'doctor_favourites',
            'patient_id',
            'doctor_id'
        );
    }

    // Appointments as patient
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    // Appointments as doctor
    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }
}
