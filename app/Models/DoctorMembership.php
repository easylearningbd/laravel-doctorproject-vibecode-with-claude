<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorMembership extends Model
{
    protected $table = 'doctor_memberships';

    protected $fillable = ['user_id', 'title', 'about'];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
