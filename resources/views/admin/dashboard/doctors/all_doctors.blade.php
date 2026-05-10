@extends('admin.admin_master')
@section('admin')

<div class="content container-fluid">
				
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">List of Doctors</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:(0);">Users</a></li>
                <li class="breadcrumb-item active">Doctor</li>
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
                <th>Doctor Name</th>
                <th>Speciality</th>
                <th>Member Since</th>
                <th>Earned</th>
                <th>Account Status</th>
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
                
                <td>14 Jan 2023 <br><small>02.59 AM</small></td>
                
                <td>$3100.00</td>
                
                <td>
                    <div class="status-toggle">
                        <input type="checkbox" id="status_1" class="check" checked>
                        <label for="status_1" class="checktoggle">checkbox</label>
                    </div>
                </td>
            </tr>
             
        </tbody>
    </table>
                </div>
            </div>
        </div>
    </div>			
</div>

</div>	

@endsection