<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    protected $table = 'payment_requests';

    protected $fillable = [
        'request_number',
        'doctor_id',
        'amount',
        'description',
        'status',
        'admin_note',
        'credited_on',
    ];

    protected function casts(): array
    {
        return [
            'amount'      => 'decimal:2',
            'credited_on' => 'date',
        ];
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
