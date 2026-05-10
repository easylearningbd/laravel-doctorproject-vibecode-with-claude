@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">List of Doctors</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('agent.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Doctors</li>
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
                                    <th>#</th>
                                    <th>Doctor Name</th>
                                    <th>Speciality</th>
                                    <th>Phone</th>
                                    <th>Member Since</th>
                                    <th>Earned</th>
                                    <th>Account Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($doctors as $doctor)
                            @php
                                $photo       = $doctor->profile_photo
                                    ? asset('storage/' . $doctor->profile_photo)
                                    : asset('backend/assets/img/doctors-dashboard/doctor-profile-img.jpg');
                                $speciality  = $doctor->primary_speciality
                                    ?: ($doctor->specialization ?: ($doctor->designation ?? '—'));
                                $doctorNum   = 'DR' . str_pad($doctor->id, 6, '0', STR_PAD_LEFT);
                            @endphp
                            <tr>
                                <td class="text-muted fs-13">#{{ $doctorNum }}</td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar avatar-sm me-2">
                                            <img class="avatar-img rounded-circle"
                                                 src="{{ $photo }}"
                                                 alt="{{ $doctor->first_name }}">
                                        </a>
                                        <span>
                                            Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                                            <small class="d-block text-muted">{{ $doctor->email }}</small>
                                        </span>
                                    </h2>
                                </td>
                                <td>{{ $speciality }}</td>
                                <td>{{ $doctor->phone ?: '—' }}</td>
                                <td>
                                    {{ $doctor->created_at->format('d M Y') }}<br>
                                    <small class="text-muted">{{ $doctor->created_at->format('h:i A') }}</small>
                                </td>
                                <td class="fw-semibold text-success">
                                    ${{ number_format($doctor->total_earned, 2) }}
                                </td>
                                <td>
                                    <span class="badge badge-success">Active</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    No doctors registered yet.
                                </td>
                            </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($doctors->hasPages())
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $doctors->links() }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>

@endsection
