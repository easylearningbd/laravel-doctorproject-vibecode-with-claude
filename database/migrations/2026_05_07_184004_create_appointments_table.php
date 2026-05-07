<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('appointment_number')->unique();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('clinic_id')->nullable()->constrained('doctor_clinics')->nullOnDelete();
            $table->json('service_ids')->nullable();
            $table->enum('appointment_type', ['clinic','video_call','audio_call','chat','home_visit'])->default('clinic');
            $table->date('appointment_date');
            $table->string('appointment_time', 5);   // HH:MM
            $table->unsignedInteger('duration_minutes')->default(30);
            $table->decimal('consultation_fee', 10, 2)->default(0);
            $table->decimal('booking_fee', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->text('symptoms')->nullable();
            $table->text('reason_for_visit')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending','confirmed','completed','cancelled'])->default('pending');
            $table->enum('payment_status', ['pending','paid','failed','refunded'])->default('pending');
            $table->string('invoice_number')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['doctor_id', 'appointment_date', 'appointment_time']);
            $table->index(['patient_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
