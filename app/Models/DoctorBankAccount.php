<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorBankAccount extends Model
{
    protected $table = 'doctor_bank_accounts';

    protected $fillable = [
        'doctor_id',
        'bank_name',
        'branch_name',
        'account_number',
        'account_name',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    // Returns masked account number: show only last 4 digits
    public function getMaskedAccountAttribute(): string
    {
        $num = $this->account_number;
        $last4 = substr(preg_replace('/\s+/', '', $num), -4);
        return 'XXXX XXXX XXXX ' . $last4;
    }
}
