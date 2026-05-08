<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    protected $table = 'prescription_items';

    protected $fillable = [
        'prescription_id',
        'medicine_name',
        'medicine_type',
        'dosage',
        'frequency',
        'duration',
        'instruction',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
