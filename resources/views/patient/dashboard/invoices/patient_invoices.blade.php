@extends('patient.patient_master')
@section('patient')

<div class="col-lg-8 col-xl-9">

<div class="dashboard-header">
    <h3>Invoices</h3>
    <ul class="header-list-btns">
        <li>
            <div class="input-block dash-search-input">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="isax isax-search-normal"></i></span>
            </div>
        </li>
    </ul>
</div>

<div class="custom-table">
    <div class="table-responsive">
        <table class="table table-center mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Doctor</th>
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
                    $apt        = $invoice->appointment;
                    $doctor     = $apt?->doctor;
                    $doctorName = $doctor
                        ? ($doctor->display_name ?: $doctor->first_name . ' ' . $doctor->last_name)
                        : '—';
                    $doctorPhoto = $doctor?->profile_photo
                        ? asset('storage/' . $doctor->profile_photo)
                        : asset('assets/img/doctors/doctor-thumb-21.jpg');
                @endphp
                <tr>
                    {{-- Invoice Number --}}
                    <td>
                        <a href="{{ route('invoice.print', $invoice->appointment->appointment_number) }}"
                           target="_blank"
                           class="link-primary fw-medium">
                            #{{ $invoice->invoice_number }}
                        </a>
                    </td>

                    {{-- Doctor --}}
                    <td>
                        <h2 class="table-avatar">
                            <a href="{{ $doctor ? route('doctor.details', $doctor->id) : '#' }}"
                               class="avatar avatar-sm me-2">
                                <img class="avatar-img rounded-3"
                                     src="{{ $doctorPhoto }}"
                                     alt="{{ $doctorName }}">
                            </a>
                            <a href="{{ $doctor ? route('doctor.details', $doctor->id) : '#' }}">
                                {{ $doctorName }}
                            </a>
                        </h2>
                    </td>

                    {{-- Appointment Date --}}
                    <td>
                        {{ $apt?->appointment_date?->format('d M Y') ?? '—' }}
                        @if ($apt?->appointment_time)
                            <span class="d-block text-muted small">
                                {{ \Carbon\Carbon::createFromFormat('H:i', $apt->appointment_time)->format('h:i A') }}
                            </span>
                        @endif
                    </td>

                    {{-- Booked On (invoice generated) --}}
                    <td>{{ $invoice->generated_at?->format('d M Y') ?? $invoice->created_at->format('d M Y') }}</td>

                    {{-- Amount --}}
                    <td class="fw-medium">${{ number_format($invoice->total, 2) }}</td>

                    {{-- Status --}}
                    <td>
                        @if ($invoice->status === 'paid')
                            <span class="badge bg-success-light">Paid</span>
                        @elseif ($invoice->status === 'generated')
                            <span class="badge bg-warning-light">Generated</span>
                        @else
                            <span class="badge bg-info-light">{{ ucfirst($invoice->status) }}</span>
                        @endif
                    </td>

                    {{-- Action --}}
                    <td>
                        <div class="action-item">
                            <a href="{{ route('invoice.print', $invoice->appointment->appointment_number) }}"
                               target="_blank"
                               title="View Invoice">
                                <i class="isax isax-link-2"></i>
                            </a>
                            <a href="{{ route('invoice.print', $invoice->appointment->appointment_number) }}"
                               target="_blank"
                               title="Download Invoice">
                                <i class="isax isax-import"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        No invoices found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if ($invoices->hasPages())
<div class="pagination dashboard-pagination">
    <ul>
        <li>
            <a href="{{ $invoices->previousPageUrl() }}"
               class="page-link prev {{ $invoices->onFirstPage() ? 'disabled' : '' }}">Prev</a>
        </li>
        @foreach ($invoices->getUrlRange(1, $invoices->lastPage()) as $page => $url)
        <li>
            <a href="{{ $url }}"
               class="page-link {{ $page == $invoices->currentPage() ? 'active' : '' }}">
                {{ $page }}
            </a>
        </li>
        @endforeach
        <li>
            <a href="{{ $invoices->nextPageUrl() }}"
               class="page-link next {{ !$invoices->hasMorePages() ? 'disabled' : '' }}">Next</a>
        </li>
    </ul>
</div>
@endif

</div>

@endsection
