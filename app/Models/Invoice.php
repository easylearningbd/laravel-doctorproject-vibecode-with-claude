<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'appointment_id',
        'invoice_number',
        'patient_id',
        'doctor_id',
        'subtotal',
        'tax',
        'discount',
        'total',
        'status',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'     => 'decimal:2',
            'tax'          => 'decimal:2',
            'discount'     => 'decimal:2',
            'total'        => 'decimal:2',
            'generated_at' => 'datetime',
        ];
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
