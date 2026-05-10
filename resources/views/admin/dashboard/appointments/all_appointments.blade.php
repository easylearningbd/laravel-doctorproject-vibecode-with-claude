@extends('admin.admin_master')
@section('admin')


<div class="content container-fluid">
				
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">Appointments</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item active">Appointments</li>
            </ul>
        </div>
    </div>
</div>
<!-- /Page Header -->
<div class="row">
    <div class="col-md-12">
    
        <!-- Recent Orders -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Speciality</th>
                                <th>Patient Name</th>
                                <th>Appointment Time</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
            <tr>
                <td>
                    <h2 class="table-avatar">
                        <a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-01.jpg" alt="User Image"></a>
                        <a href="profile.html">Dr. Ruby Perrin</a>
                    </h2>
                </td>
                <td>Dental</td>
                <td>
                    <h2 class="table-avatar">
                        <a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient1.jpg" alt="User Image"></a>
                        <a href="profile.html">Charlene Reed </a>
                    </h2>
                </td>
                <td>9 Nov 2023 <span class="text-primary d-block">11.00 AM - 11.15 AM</span></td>
                <td>
                    <div class="status-toggle">
                        <input type="checkbox" id="status_1" class="check" checked>
                        <label for="status_1" class="checktoggle">checkbox</label>
                    </div>
                </td>
                <td>
                    $200.00
                </td>
            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Recent Orders -->
        
    </div>
</div>
</div>





@endsection