<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorClinic extends Model
{
    protected $table = 'doctor_clinics';

    protected $fillable = [
        'user_id',
        'clinic_name',
        'location',
        'address',
        'logo',
        'gallery',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
