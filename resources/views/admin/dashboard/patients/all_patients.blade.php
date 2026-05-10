@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">List of Patients</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('agent.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Patients</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>Patient Name</th>
                                    <th>Age</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Last Visit</th>
                                    <th>Total Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($patients as $patient)
                            @php
                                $photo      = $patient->profile_photo
                                    ? asset('storage/' . $patient->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/profile-01.jpg');
                                $patientNum = 'PT' . str_pad($patient->id, 6, '0', STR_PAD_LEFT);
                                $age        = $patient->dob
                                    ? \Carbon\Carbon::parse($patient->dob)->age
                                    : '—';
                                $address    = collect([
                                                $patient->address,
                                                $patient->city,
                                                $patient->state,
                                                $patient->country,
                                             ])->filter()->implode(', ') ?: '—';
                                $lastVisit  = $patient->last_visit
                                    ? \Carbon\Carbon::parse($patient->last_visit)->format('d M Y')
                                    : '—';
                            @endphp
                            <tr>
                                <td class="fw-medium text-primary">#{{ $patientNum }}</td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $photo }}"
                                                 alt="{{ $patient->first_name }}">
                                        </a>
                                        <span>
                                            {{ $patient->first_name }} {{ $patient->last_name }}
                                            <small class="d-block text-muted">{{ $patient->email }}</small>
                                        </span>
                                    </h2>
                                </td>
                                <td>{{ $age }}</td>
                                <td style="max-width:220px;">
                                    <span title="{{ $address }}">
                                        {{ \Illuminate\Support\Str::limit($address, 50) }}
                                    </span>
                                </td>
                                <td>{{ $patient->phone ?: '—' }}</td>
                                <td>{{ $lastVisit }}</td>
                                <td class="fw-semibold text-success">
                                    ${{ number_format($patient->total_paid, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No patients registered yet.
                                </td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($patients->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $patients->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

@endsection
