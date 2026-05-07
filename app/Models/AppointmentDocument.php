<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentDocument extends Model
{
    protected $table = 'appointment_documents';

    protected $fillable = [
        'appointment_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
