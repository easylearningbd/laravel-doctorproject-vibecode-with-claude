<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $table = 'prescriptions';

    protected $fillable = [
        'prescription_number',
        'doctor_id',
        'patient_id',
        'appointment_id',
        'prescription_type',
        'issued_date',
        'other_info',
        'follow_up',
    ];

    protected function casts(): array
    {
        return [
            'issued_date' => 'date',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }
}
