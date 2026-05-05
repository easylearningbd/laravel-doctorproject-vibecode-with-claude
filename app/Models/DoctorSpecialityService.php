<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSpecialityService extends Model
{
    protected $table = 'doctor_speciality_services';

    protected $fillable = [
        'user_id',
        'speciality_id',
        'service_name',
        'price',
        'about',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }
}
