<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'patient';
    }

    public function rules(): array
    {
        return [
            // Step 1
            'service_ids'      => 'nullable|array',
            'service_ids.*'    => 'integer|exists:doctor_speciality_services,id',

            // Step 2
            'appointment_type' => 'required|in:clinic,video_call,audio_call,chat,home_visit',
            'clinic_id'        => 'nullable|exists:doctor_clinics,id',

            // Step 3
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => ['required', 'regex:/^\d{2}:\d{2}$/'],

            // Step 4
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'phone'            => 'required|string|max:20',
            'email'            => 'required|email',
            'symptoms'         => 'nullable|string|max:1000',
            'reason_for_visit' => 'nullable|string|max:1000',
            'attachment'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',

            // Step 5
            'card_holder_name' => 'required|string|max:100',
            'card_number'      => 'required|string|min:13|max:19',
            'card_expiry'      => 'required|string|max:7',
            'card_cvv'         => 'required|string|min:3|max:4',
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_date.after_or_equal' => 'Appointment date must be today or a future date.',
            'appointment_time.regex'           => 'Invalid time format.',
            'card_number.min'                  => 'Please enter a valid card number.',
        ];
    }
}
