<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorEducation extends Model
{
    protected $table = 'doctor_educations';

    protected $fillable = [
        'user_id',
        'institution_name',
        'course',
        'start_date',
        'end_date',
        'no_of_years',
        'description',
        'logo',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
