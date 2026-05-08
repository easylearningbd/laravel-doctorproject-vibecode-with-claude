<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedicalRecord extends Model
{
    protected $table = 'patient_medical_records';

    protected $fillable = [
        'patient_id',
        'record_number',
        'title',
        'record_for',
        'record_date',
        'comments',
        'file_path',
        'file_original_name',
    ];

    protected function casts(): array
    {
        return [
            'record_date' => 'date',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
