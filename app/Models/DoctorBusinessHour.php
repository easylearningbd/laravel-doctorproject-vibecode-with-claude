<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorBusinessHour extends Model
{
    protected $table = 'doctor_business_hours';

    protected $fillable = [
        'user_id',
        'day_of_week',
        'is_open',
        'start_time',
        'end_time',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
