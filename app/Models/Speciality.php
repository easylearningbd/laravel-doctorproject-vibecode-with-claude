<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $fillable = ['name', 'image'];

    public function services()
    {
        return $this->hasMany(DoctorSpecialityService::class, 'speciality_id');
    }
}
