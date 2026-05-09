<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice — {{ $appointment->invoice_number }}</title>
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap.min.css') }}">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #fff; color: #333; }
        .invoice-wrap { max-width: 780px; margin: 40px auto; padding: 40px; border: 1px solid #e0e0e0; border-radius: 12px; }
        .invoice-header { border-bottom: 2px solid #4f46e5; padding-bottom: 20px; margin-bottom: 24px; }
        .logo-title { font-size: 24px; font-weight: 700; color: #4f46e5; }
        .badge-status { background: #22c55e; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; }
        .info-box { background: #f8fafc; border-radius: 8px; padding: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #4f46e5; color: #fff; padding: 10px 14px; text-align: left; }
        td { padding: 10px 14px; border-bottom: 1px solid #f0f0f0; }
        .total-row td { font-weight: 700; font-size: 16px; background: #f0f0ff; }
        .footer-note { font-size: 12px; color: #888; margin-top: 24px; text-align: center; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
            .invoice-wrap { border: none; margin: 0; padding: 20px; }
        }
    </style>
</head>
<body>

@php
    $doctor     = $appointment->doctor;
    $patient    = $appointment->patient;
    $doctorName = $doctor->display_name ?: 'Dr. ' . $doctor->first_name . ' ' . $doctor->last_name;
    $apptDate   = $appointment->appointment_date->format('d M Y');
    $apptTime   = \Carbon\Carbon::createFromFormat('H:i', $appointment->appointment_time)->format('h:i A');
@endphp

<div class="invoice-wrap">

    <!-- Print button -->
    <div class="text-end mb-3 no-print">
        <button onclick="window.print()" class="btn btn-primary btn-sm">
            🖨 Print / Save as PDF
        </button>
        <a href="{{ $backUrl ?? route('appointment.success', $appointment->appointment_number) }}"
           class="btn btn-light btn-sm ms-2">← Back</a>
    </div>

    <!-- Header -->
    <div class="invoice-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <div class="logo-title">🏥 Doccure</div>
            <p class="text-muted small mb-0">Healthcare Appointment Platform</p>
        </div>
        <div class="text-end">
            <h4 class="mb-1">INVOICE</h4>
            <div class="fw-bold text-primary">{{ $appointment->invoice_number }}</div>
            <div class="text-muted small">Generated: {{ now()->format('d M Y, h:i A') }}</div>
            <span class="badge-status mt-1 d-inline-block">{{ strtoupper($appointment->payment_status) }}</span>
        </div>
    </div>

    <!-- Doctor & Patient Info -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="info-box">
                <div class="fw-bold text-muted small mb-2">BILLED FROM</div>
                <div class="fw-bold">{{ $doctorName }}</div>
                @if ($doctor->designation)<div class="text-muted small">{{ $doctor->designation }}</div>@endif
                <div class="small">{{ collect([$doctor->city, $doctor->country])->filter()->implode(', ') ?: 'Location not set' }}</div>
                <div class="small text-muted">{{ $doctor->email }}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box">
                <div class="fw-bold text-muted small mb-2">BILLED TO</div>
                <div class="fw-bold">{{ $patient->first_name }} {{ $patient->last_name }}</div>
                <div class="small text-muted">{{ $patient->email }}</div>
                <div class="small text-muted">{{ $patient->phone }}</div>
                @if ($patient->address)<div class="small text-muted">{{ $patient->address }}</div>@endif
            </div>
        </div>
    </div>

    <!-- Appointment Details -->
    <div class="info-box mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="fw-bold small text-muted">Appointment No.</div>
                <div class="fw-bold text-primary">{{ $appointment->appointment_number }}</div>
            </div>
            <div class="col-md-3">
                <div class="fw-bold small text-muted">Date</div>
                <div>{{ $apptDate }}</div>
            </div>
            <div class="col-md-3">
                <div class="fw-bold small text-muted">Time</div>
                <div>{{ $apptTime }}</div>
            </div>
            <div class="col-md-3">
                <div class="fw-bold small text-muted">Type</div>
                <div>{{ str_replace('_', ' ', ucfirst($appointment->appointment_type)) }}</div>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    <table class="mb-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Service</th>
                <th>Speciality</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $i => $svc)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $svc->service_name }}</td>
                <td>{{ $svc->speciality?->name ?? '—' }}</td>
                <td class="text-end">${{ number_format($svc->price, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Consultation service</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="3">Booking Fee</td>
                <td class="text-end">${{ number_format($appointment->booking_fee, 2) }}</td>
            </tr>
            <tr>
                <td colspan="3">Tax (5%)</td>
                <td class="text-end">${{ number_format($appointment->tax, 2) }}</td>
            </tr>
            @if ($appointment->discount > 0)
            <tr>
                <td colspan="3">Discount</td>
                <td class="text-end text-danger">-${{ number_format($appointment->discount, 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td colspan="3">Total Paid</td>
                <td class="text-end text-primary">${{ number_format($appointment->total_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Payment Info -->
    @if ($appointment->payment)
    <div class="info-box mb-4">
        <div class="fw-bold small text-muted mb-2">PAYMENT INFORMATION</div>
        <div class="row">
            <div class="col-md-4">
                <div class="small text-muted">Method</div>
                <div>{{ str_replace('_', ' ', ucfirst($appointment->payment->payment_method)) }}</div>
            </div>
            <div class="col-md-4">
                <div class="small text-muted">Transaction ID</div>
                <div class="fw-bold">{{ $appointment->payment->transaction_id }}</div>
            </div>
            <div class="col-md-4">
                <div class="small text-muted">Paid At</div>
                <div>{{ $appointment->payment->paid_at?->format('d M Y, h:i A') }}</div>
            </div>
            @if ($appointment->payment->card_last_four)
            <div class="col-md-4 mt-2">
                <div class="small text-muted">Card</div>
                <div>•••• •••• •••• {{ $appointment->payment->card_last_four }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="footer-note">
        <p>Thank you for choosing Doccure. This is a system-generated invoice.</p>
        <p>For support, contact us at support@doccure.com</p>
    </div>

</div>

</body>
</html>
