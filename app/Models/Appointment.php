<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'appointment_number',
        'patient_id',
        'doctor_id',
        'clinic_id',
        'service_ids',
        'appointment_type',
        'appointment_date',
        'appointment_time',
        'duration_minutes',
        'consultation_fee',
        'booking_fee',
        'tax',
        'discount',
        'total_amount',
        'symptoms',
        'reason_for_visit',
        'notes',
        'status',
        'payment_status',
        'invoice_number',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'service_ids'      => 'array',
            'consultation_fee' => 'decimal:2',
            'booking_fee'      => 'decimal:2',
            'tax'              => 'decimal:2',
            'discount'         => 'decimal:2',
            'total_amount'     => 'decimal:2',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function clinic()
    {
        return $this->belongsTo(DoctorClinic::class, 'clinic_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function documents()
    {
        return $this->hasMany(AppointmentDocument::class);
    }

    // Scope: upcoming appointments
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                     ->whereIn('status', ['pending', 'confirmed']);
    }

    // Formatted appointment time (h:i A)
    public function getFormattedTimeAttribute(): string
    {
        return \Carbon\Carbon::createFromFormat('H:i', $this->appointment_time)->format('h:i A');
    }
}
