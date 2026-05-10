@extends('admin.admin_master')
@section('admin')

 <div class="content container-fluid">
				
<!-- Page Header -->
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">List of Patient</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:(0);">Users</a></li>
                <li class="breadcrumb-item active">Patient</li>
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
            <th>Paid</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>#PT001</td>
            <td>
                <h2 class="table-avatar">
                    <a href="profile.html" class="avatar avatar-sm me-2"><img class="avatar-img rounded-circle" src="assets/img/patients/patient1.jpg" alt="User Image"></a>
                    <a href="profile.html">Charlene Reed </a>
                </h2>
            </td>
            <td>29</td>
            <td>4417  Goosetown Drive, Taylorsville, North Carolina, 28681</td>
            <td>8286329170</td>
            <td>20 Oct 2023</td>
            <td>$100.00</td>
        </tr>
        
    </tbody>
</table>
                </div>
                </div>
            </div>
        </div>
    </div>			
</div>

</div>	

@endsection