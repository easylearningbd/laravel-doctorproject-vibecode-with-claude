<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorExperience extends Model
{
    protected $table = 'doctor_experiences';

    protected $fillable = [
        'user_id',
        'hospital_name',
        'title',
        'years_of_experience',
        'location',
        'employment_type',
        'description',
        'start_date',
        'end_date',
        'currently_working',
        'logo',
    ];

    protected function casts(): array
    {
        return [
            'start_date'        => 'date',
            'end_date'          => 'date',
            'currently_working' => 'boolean',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
