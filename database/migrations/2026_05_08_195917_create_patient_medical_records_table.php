<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->string('record_number')->unique();    // MR-2026-000001
            $table->string('title');
            $table->string('record_for');                // patient name / family member
            $table->date('record_date');
            $table->text('comments')->nullable();
            $table->string('file_path')->nullable();           // stored relative path
            $table->string('file_original_name')->nullable();  // original filename for download
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_medical_records');
    }
};
