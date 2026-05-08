@extends('doctor.doctor_master')
@section('doctor')


 
<div class="appointment-patient">

<div class="dashboard-header">
    <h3><a href="my-patients.html"><i class="fa-solid fa-arrow-left"></i> Patient Details</a></h3>
</div>

<div class="patient-wrap">
    <div class="patient-info">
        <img src="assets/img/doctors-dashboard/profile-01.jpg" alt="img">
        <div class="user-patient">
            <h6>#P0016</h6>
            <h5>Adrian Marshall</h5>
            <ul>
                <li>Age : 42</li>
                <li>Male</li>
                <li>AB+ve</li>
            </ul>
        </div>
    </div>
    <div class="patient-book">
        <p><i class="isax isax-calendar-1"></i>Last Booking</p>
        <p>24 Mar 2024</p>
    </div>
</div>

<!-- Appoitment Tabs -->
<div class="appointment-tabs user-tab">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" href="#pat_appointments" data-bs-toggle="tab">Appointments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#prescription" data-bs-toggle="tab">Prescription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#medical" data-bs-toggle="tab">Medical Records</a>
        </li>
       
    </ul>
</div>
<!-- /Appoitment Tabs -->

<div class="tab-content pt-0">
        
    <!-- Appointment Tab -->
    <div id="pat_appointments" class="tab-pane fade show active">

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
                            <th>ID</th>
                            <th>Doctor</th>
                            <th>Appt Date</th>
                            <th>Booking Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <tr>
        <td><a class="text-blue-600" href="patient-upcoming-appointment.html">#Apt123</a></td>
        <td>
            <h2 class="table-avatar">
                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                    <img class="avatar-img rounded-3" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                </a>
                <a href="doctor-profile.html">Edalin Hendry</a>
            </h2>
        </td>
        <td>24 Mar 2024</td>
        <td>21 Mar 2024</td>
        <td>$300</td>
        <td><span class="badge badge-yellow status-badge">Upcoming</span></td>
        <td>
            <div class="action-item">
                <a href="patient-upcoming-appointment.html">
                    <i class="isax isax-link-2"></i>
                </a>
            </div>
        </td>
    </tr>
                         
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li>
                    <a href="#" class="page-link">1</a>
                </li>
                <li>
                    <a href="#" class="page-link active">2</a>
                </li>
                <li>
                    <a href="#" class="page-link">3</a>
                </li>
                <li>
                    <a href="#" class="page-link">4</a>
                </li>
                <li>
                    <a href="#" class="page-link">...</a>
                </li>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->

    </div>
    <!-- /Appointment Tab -->
        
    <!-- Prescription Tab -->
    <div class="tab-pane fade" id="prescription">
        <div class="search-header">
            <div class="search-field">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
            <div>
                <a href="#" class="btn btn-primary prime-btn" data-bs-toggle="modal" data-bs-target="#add_prescription">Add New Prescription</a>
            </div>
        </div>

        <div class="custom-table">
            <div class="table-responsive">
                <table class="table table-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Prescriped By</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <tr>
        <td><a href="javascript:void(0);" class="text-blue-600" data-bs-toggle="modal" data-bs-target="#view_prescription">#Apt123</a></td>
        <td>
            <h2 class="table-avatar">
                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                    <img class="avatar-img rounded-3" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                </a>
                <a href="doctor-profile.html">Edalin Hendry</a>
            </h2>
        </td>
        <td>Visit</td>
        <td>25 Jan 2024</td>
        <td>
            <div class="action-item">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_prescription">
                    <i class="isax isax-link-2"></i>
                </a>
            </div>
        </td>
    </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li>
                    <a href="#" class="page-link">1</a>
                </li>
                <li>
                    <a href="#" class="page-link active">2</a>
                </li>
                <li>
                    <a href="#" class="page-link">3</a>
                </li>
                <li>
                    <a href="#" class="page-link">4</a>
                </li>
                <li>
                    <a href="#" class="page-link">...</a>
                </li>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->

    </div>
    <!-- /Prescription Tab -->

    <!-- Medical Records Tab -->
    <div class="tab-pane fade" id="medical">
        <div class="search-header">
            <div class="search-field">
                <input type="text" class="form-control" placeholder="Search">
                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            </div>
            <div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add_medical_records" class="btn btn-primary prime-btn">Add Medical Record</a>
            </div>
        </div>

        <div class="custom-table">
            <div class="table-responsive">
                <table class="table table-center mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <tr>
        <td>
            <a href="javascript:void(0);" class="lab-icon">
                <span><i class="fa-solid fa-paperclip"></i></span>Lab Report
            </a>
        </td>
        <td>24 Mar 2024</td>
        <td>Glucose Test V12</td>
        <td>
            <div class="action-item">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_medical_records">
                    <i class="isax isax-edit-2"></i>
                </a>
                <a href="javascript:void(0);">
                    <i class="isax isax-import"></i>
                </a>
                <a href="javascript:void(0);">
                    <i class="isax isax-trash"></i>
                </a>
            </div>
        </td>
    </tr>
                         
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination dashboard-pagination">
            <ul>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <li>
                    <a href="#" class="page-link">1</a>
                </li>
                <li>
                    <a href="#" class="page-link active">2</a>
                </li>
                <li>
                    <a href="#" class="page-link">3</a>
                </li>
                <li>
                    <a href="#" class="page-link">4</a>
                </li>
                <li>
                    <a href="#" class="page-link">...</a>
                </li>
                <li>
                    <a href="#" class="page-link"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->

    </div>
    <!-- /Medical Records Tab -->
        
    
                
</div>
</div>
 




<!--View Prescription -->
		<div class="modal fade custom-modals" id="view_prescription">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">View Prescription</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>				
					<div class="modal-body pb-0">
						<div class="prescribe-download">
							<h5>21 Mar  2024</h5>
							<ul>
								<li><a href="javascript:void(0);" class="print-link"><i class="fa-solid fa-print"></i></a></li>
								<li><a href="#" class="btn btn-primary prime-btn">Download</a></li>
							</ul>							
						</div>
						<div class="view-prescribe invoice-content">
							<div class="invoice-item">
								<div class="row">
									<div class="col-md-6">
										<div class="invoice-logo">
											<img src="assets/img/logo.png" alt="logo">
										</div>
									</div>
									<div class="col-md-6">
										<p class="invoice-details">
											<strong>Prescription ID :</strong> #PR-123 <br>
											<strong>Issued:</strong> 21 Mar 2024
										</p>
									</div>
								</div>
							</div>
							
							<!-- Invoice Item -->
							<div class="invoice-item">
								<div class="row">
									<div class="col-md-6">
										<div class="invoice-info">
											<h6 class="customer-text">Doctor Details</h6>
											<p class="invoice-details invoice-details-two">
												Edalin Hendry <br>
												806 Twin Willow Lane, <br>
												Newyork, USA <br>
											</p>
										</div>
									</div>
									<div class="col-md-6">
										<div class="invoice-info invoice-info2">
											<h6 class="customer-text">Patient Details</h6>
											<p class="invoice-details">
												Adrian Marshall <br>
												299 Star Trek Drive,<br>
												Florida, 32405, USA <br>
											</p>
										</div>
									</div>
								</div>
							</div>
							<!-- /Invoice Item -->
							
							<!-- Invoice Item -->
							<div class="invoice-item invoice-table-wrap">
								<div class="row">
									<div class="col-md-12">
										<h6>Prescription  Details</h6>
										<div class="table-responsive">
											<table class="invoice-table table table-bordered">
												<thead>
													<tr>
														<th>Medicine Name</th>
														<th>Dosage</th>
														<th>Frequency</th>
														<th>Duration</th>
														<th>Timings</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Ecosprin 75MG [Asprin 75 MG Oral Tab]</td>
														<td>75 mg <span>Oral Tab</span></td>
														<td>1-0-0-1</td>
														<td>1 month</td>
														<td>Before Meal</td>
													</tr>
													<tr>
														<td>Alexer 90MG Tab</td>
														<td>90 mg <span>Oral Tab</span></td>
														<td>1-0-0-1</td>
														<td>1 month</td>
														<td>Before Meal</td>
													</tr>
													<tr>
														<td>Ramistar XL2.5</td>
														<td>60 mg <span>Oral Tab</span></td>
														<td>1-0-0-0</td>
														<td>1 month</td>
														<td>After Meal</td>
													</tr>
													<tr>
														<td>Metscore</td>
														<td>90 mg <span>Oral Tab</span></td>
														<td>1-0-0-1</td>
														<td>1 month</td>
														<td>After Meal</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- /Invoice Item -->
							
							<!-- Invoice Information -->
							<div class="other-info">
								<h4>Other information</h4>
								<p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed dictum ligula, cursus blandit risus. Maecenas eget metus non tellus dignissim aliquam ut a ex. Maecenas sed vehicula dui, ac suscipit lacus. Sed finibus leo vitae lorem interdum, eu scelerisque tellus fermentum. Curabitur sit amet lacinia lorem. Nullam finibus pellentesque libero.</p>
							</div>
							<div class="other-info">
								<h4>Follow Up</h4>
								<p class="text-muted mb-0">Follow u p after 3 months, Have to come on empty stomach</p>
							</div>
							<div class="prescriber-info">
								<h6>Dr. Edalin Hendry</h6>
								<p>Dept of Cardiology</p>
							</div>
							<!-- /Invoice Information -->
							
						</div>	
					</div>
				</div>
			</div>
		</div>
		<!-- /View Prescription -->



	<!-- Add Prescription -->
		<div class="modal fade custom-modals" id="add_prescription">
			<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Add Prescription</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<form action="patient-profile.html">					
						<div class="modal-body">
							<div class="patient-wrap">
								<div class="patient-info mt-0">
									<img src="assets/img/doctors-dashboard/profile-01.jpg" alt="img">
									<div class="user-patient">
										<h6>#P0016</h6>
										<h5>Adrian Marshall</h5>
										<ul>
											<li>299 Star Trek Drive, Florida, 32405, USA</li>
										</ul>
									</div>
								</div>
								<div class="patient-book patien-inv">
									<h6>#INV0001</h6>
									<p>1 November 2023</p>
								</div>
							</div>
							<div class="add-prescripe-info">
								<div class="row prescripe-cont">
									<div class="col-xl-2 xol-lg-3 col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">Name</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-xl-2 xol-lg-3 col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">Type</label>
											<select class="select">
												<option>Select</option>
												<option>Visit</option>
												<option>Online</option>
											</select>
										</div>
									</div>
									<div class="col-xl-2 xol-lg-3 col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">Dosage</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-xl-2 xol-lg-3 col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">Frequency</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-xl-2 xol-lg-3 col-md-6">
										<div class="form-wrap">
											<label class="col-form-label">Duration</label>
											<select class="select">
												<option>Select</option>
												<option>1 Month</option>
												<option>1 Day</option>
											</select>
										</div>
									</div>
									<div class="col-xl-2 xol-lg-3 col-md-6">
										<div class="d-flex align-items-center">
											<div class="form-wrap w-100">
												<label class="col-form-label">Instruction</label>
												<input type="text" class="form-control">
											</div>
											<div class="form-wrap ms-2">
												<label class="col-form-label d-block">&nbsp;</label>
												<a href="#" class="trash"><i class="isax isax-trash"></i></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="text-end">
								<a href="#" class="add-prescribe">Add More</a>
							</div>
							<div class="wrap-sign">
								<div class="row">
									<div class="col-md-12">
										<div class="sign-wrapper">
											<div class="upload-sign">
												<p>Click here to sign</p>
											</div>
											<div class="info-name">
												<h6>( Dr. Darren Elder )</h6>
												<p>Signature</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">					
							<div class="modal-btn text-end">
								<a href="#" class="btn btn-gray" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
								<button type="submit" class="btn btn-primary prime-btn">Save Changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Prescription -->






@endsection