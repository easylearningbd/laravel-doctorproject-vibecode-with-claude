@extends('doctor.doctor_master')
@section('doctor')

<div class="dashboard-header">
    <h3>Invoices</h3>
</div>

<div class="search-header">
    <div class="search-field">
        <input type="text" class="form-control" placeholder="Search">
        <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
    </div>
</div>

<div class="custom-table">
    <div class="table-responsive">
        <table class="table table-center mb-0">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Patient</th>
                    <th>Appointment Date</th>
                    <th>Booked On</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($invoices as $invoice)
            @php
                $patient    = $invoice->patient;
                $appointment = $invoice->appointment;
                $photo      = $patient?->profile_photo
                    ? asset('storage/' . $patient->profile_photo)
                    : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
                $apptDate   = $appointment?->appointment_date?->format('d M Y') ?? '—';
                $bookedOn   = $appointment?->created_at?->format('d M Y') ?? $invoice->generated_at?->format('d M Y') ?? '—';
                $badgeClass = match($invoice->status ?? 'paid') {
                    'paid'    => 'badge-success',
                    'pending' => 'badge-yellow',
                    'overdue' => 'badge-danger',
                    default   => 'badge-success',
                };
            @endphp
            <tr>
                <td>
                    <a href="{{ route('doctor.invoice.print', $appointment->appointment_number) }}"
                       class="text-primary fw-medium">
                        #{{ $invoice->invoice_number }}
                    </a>
                </td>
                <td>
                    <h2 class="table-avatar">
                        <a href="{{ route('patient.details.page', $patient->id) }}"
                           class="avatar avatar-sm me-2">
                            <img class="avatar-img rounded-3" src="{{ $photo }}"
                                 alt="{{ $patient?->first_name }}">
                        </a>
                        <a href="{{ route('patient.details.page', $patient->id) }}">
                            {{ $patient?->first_name }} {{ $patient?->last_name }}
                        </a>
                    </h2>
                </td>
                <td>{{ $apptDate }}</td>
                <td>{{ $bookedOn }}</td>
                <td>${{ number_format($invoice->total, 2) }}</td>
                <td>
                    <span class="badge {{ $badgeClass }} status-badge">
                        {{ ucfirst($invoice->status ?? 'Paid') }}
                    </span>
                </td>
                <td>
                    <div class="action-item">
                        {{-- View / Print (opens print-ready page) --}}
                        <a href="{{ route('doctor.invoice.print', $appointment->appointment_number) }}"
                           target="_blank" title="View & Print">
                            <i class="isax isax-link-2"></i>
                        </a>
                        {{-- Direct print trigger --}}
                        <a href="{{ route('doctor.invoice.print', $appointment->appointment_number) }}"
                           target="_blank" title="Print Invoice"
                           onclick="var w=window.open(this.href,'_blank');w.onload=function(){w.print();};return false;">
                            <i class="isax isax-printer5"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5">
                    <i class="isax isax-document fs-1 text-muted mb-3 d-block"></i>
                    <p class="text-muted">No invoices found.</p>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@if ($invoices->hasPages())
<div class="mt-3 d-flex justify-content-center">
    {{ $invoices->links() }}
</div>
@endif

@endsection
