@extends('patient.patient_master')
@section('patient')



<div class="col-lg-8 col-xl-9">

<div class="dashboard-header flex-wrap">
    <h3>Records</h3>
    <div class="appointment-tabs">
        <ul class="nav">
            <li>
                <a href="#" class="nav-link active" data-bs-toggle="tab" data-bs-target="#medical">Medical Records</a>
            </li>
            <li>
                <a href="#" class="nav-link" data-bs-toggle="tab" data-bs-target="#prescription">Prescriptions</a>
            </li>
        </ul>
    </div>
</div>

<div class="tab-content pt-0">

    <!-- Prescription Tab -->
    <div class="tab-pane fade" id="prescription">
        <div class="dashboard-header border-0 m-0">
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
                            <th>Name</th>
                            <th>Created Date</th>
                            <th>Prescriped By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <tr>
        <td><a class="link-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_prescription">#P1236</a></td>
        <td>
            <a href="javascript:void(0);" class="lab-icon prescription">Prescription</a>
        </td>
        <td>24 Mar 2024, 10:30 AM</td>
        <td>
            <h2 class="table-avatar">
                <a href="doctor-profile.html" class="avatar avatar-sm me-2">
                    <img class="avatar-img rounded-3" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                </a>
                <a href="doctor-profile.html">Edalin Hendry</a>
            </h2>
        </td>
        <td>
            <div class="action-item">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_prescription">
                    <i class="isax isax-link-2"></i>
                </a>
                <a href="javascript:void(0);">
                    <i class="isax isax-import"></i>
                </a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal">
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
                    <a href="#" class="page-link prev">Prev</a>
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
                    <a href="#" class="page-link next">Next</a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->

    </div>
    <!-- /Prescription Tab -->

    <!-- Medical Records Tab -->
    <div class="tab-pane fade show active" id="medical">
        <div class="dashboard-header border-0 m-0">
            <ul class="header-list-btns">
                <li>
                    <div class="input-block dash-search-input">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="search-icon"><i class="isax isax-search-normal"></i></span>
                    </div>
                </li>
            </ul>
            <a href="#" class="btn btn-md btn-primary-gradient rounded-pill" data-bs-toggle="modal" data-bs-target="#add_medical_records">Add Medical Record</a>
        </div>

        <div class="custom-table">
            <div class="table-responsive">
                <table class="table table-center mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Record For</th>
                            <th>Comments</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <tr>
        <td><a class="link-primary" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_report">#MR1236</a></td>
        <td>
            <a href="javascript:void(0);" class="lab-icon">Electro cardiography</a>
        </td>
        <td>24 Mar 2024</td>
        <td>
            <h2 class="table-avatar">
                <a href="patient-details.html" class="avatar avatar-sm me-2">
                    <img class="avatar-img rounded-3" src="assets/img/doctors-dashboard/profile-06.jpg" alt="User Image">
                </a>
                <a href="paitent-details.html">Hendrita Clark</a>
            </h2>
        </td>
        <td>Take Good Rest</td>
        <td>
            <div class="action-item">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#view_report">
                    <i class="isax isax-link-2"></i>
                </a>
                <a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#edit_medical_records">
                    <i class="isax isax-edit-2"></i>
                </a>
                <a href="javascript:void(0);">
                    <i class="isax isax-import"></i>
                </a>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete_modal">
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
                    <a href="#" class="page-link prev">Prev</a>
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
                    <a href="#" class="page-link next">Next</a>
                </li>
            </ul>
        </div>
        <!-- /Pagination -->

    </div>
    <!-- /Medical Records Tab -->


</div>

</div>






<!-- Add Medical Records Modal -->
<div class="modal fade custom-modals" id="add_medical_records">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Medical Record</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form>					
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Record  For <span class="text-danger">*</span></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control datetimepicker">
                                    <span class="icon"><i class="isax isax-calendar-1"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Comments <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Record <span class="text-danger">*</span></label>
                                <div>
                                    <div class="file-upload">
                                        <input type="file">
                                        <p><i class="isax isax-document-upload me-1"></i>Upload File</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">					
                    <div class="modal-btn text-end">
                        <a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Add Medical Records</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Add Medical Records Modal -->

<!-- Edit Medical Records Modal -->
<div class="modal fade custom-modals" id="edit_medical_records">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Medical Record</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form>					
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="mb-3">
                            <label class="col-form-label">Title</label>
                            <input type="text" class="form-control" value="Glucose Test V12">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Record  For <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="Hendrita Clark">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Date <span class="text-danger">*</span></label>
                                <div class="form-icon">
                                    <input type="text" class="form-control datetimepicker" value="23/04/2024">
                                    <span class="icon"><i class="isax isax-calendar-1"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Comments <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3">Take Good Rest</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Record <span class="text-danger">*</span></label>
                                <div>
                                    <div class="file-upload">
                                        <input type="file">
                                        <p><i class="isax isax-document-upload me-1"></i>Upload File</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">					
                    <div class="modal-btn text-end">
                        <a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-toggle="modal" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Save Medical Records</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Edit Medical Records Modal -->		

    <!--View Report -->
    <div class="modal fade custom-modals" id="view_report">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">View Report</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>				
            <div class="modal-body pb-0">
                <div class="prescribe-download gap-2">
                    <h5>21 Mar  2024</h5>
                    <ul>
                        <li><a href="javascript:void(0);" class="print-link"><i class="fa-solid fa-print"></i></a></li>
                        <li><a href="#" class="btn btn-md btn-primary-gradient rounded-pill">Download</a></li>
                    </ul>							
                </div>
                <div class="view-prescribe-details p-0 border-0">
                    
                    <!-- Invoice Item -->
                    <div class="invoice-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="invoice-info d-flex align-items-center">
                                    <div class="clinic-image d-inline-flex align-items-center justify-content-center">
                                        <img src="assets/img/icons/vtaplus.svg" alt="img">
                                    </div>
                                    <div>
                                        <h6 class="fs-16 fw-semibold">Vitalplus Clinic</h6>
                                        <p class="fs-14 fw-medium">Dr. Sandy Maria</p>
                                        <p class="fs-14">MBLS,MS</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="invoice-info2">
                                    <p><span>Test Type : </span>CBC</p>
                                    <p><span>Collected On : </span>20 Mar 2024, 10:00 AM</p>
                                    <p><span>Reported On :  </span>21 Mar 2024, 11:00 AM</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="patient-infos d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                    <div class="d-flex align-items-center">
                                        <span class="avatar me-2">
                                            <img src="assets/img/doctors-dashboard/profile-06.jpg" class="rounded" alt="img">
                                        </span>
                                        <div>
                                            <h6 class="fs-14 fw-medium">Hendrita Kearns</h6>
                                            <p>Patient ID : PT254654</p>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="fs-14 fw-medium">Gender</h6>
                                        <p>Female</p>
                                    </div>
                                    <div>
                                        <h6 class="fs-14 fw-medium">Age</h6>
                                        <p>32 years </p>
                                    </div>
                                    <div>
                                        <h6 class="fs-14 fw-medium">Blood</h6>
                                        <p>O+</p>
                                    </div>
                                    <div>
                                        <h6 class="fs-14 fw-medium">Type</h6>
                                        <p>Outpatient</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Invoice Item -->
                    
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                        <h6>Complete Blood Count(CBC)</h6>
                        <p class="fs-14 mb-0"><span class="text-gray-9">Primary Test Type :</span> Blood</p>
                    </div>

                    <!-- Invoice Item -->
                    <div class="invoice-item invoice-table-wrap">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive inv-table">
                                    <table class="invoice-table table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Investigation</th>
                                                <th>Result</th>
                                                <th>Reference Value</th>
                                                <th>Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="report-title" colspan="4">HEMOGLOBIN</td>
                                            </tr>
                                            <tr>
                                                <td>Hemoglobin (Hb)</td>
                                                <td>12.5<span class="badge badge-info-transparent text-xs d-inline-block rounded-pill ms-1">Low</span></td>
                                                <td>13.0 - 17.0</td>
                                                <td>g/dL</td>
                                            </tr>
                                            <tr>
                                                <td class="report-title" colspan="4">RBC COUNT</td>
                                            </tr>
                                            <tr>
                                                <td>Total RBC Count</td>
                                                <td>5.2</td>
                                                <td>4.5 - 5.5</td>
                                                <td>million cells/µL</td>
                                            </tr>
                                            <tr>
                                                <td class="report-title" colspan="4">BLOOD INDICES</td>
                                            </tr>
                                            <tr>
                                                <td>Packed Cell Volume (PCV)</td>
                                                <td class="text-danger">57.5<span class="badge badge-danger-transparent text-xs d-inline-block rounded-pill ms-1">High</span></td>
                                                <td>40 - 50</td>
                                                <td>%</td>
                                            </tr>
                                            <tr>
                                                <td>Mean Corpuscular Volume (MCV) <span class="fs-10 text-gray-6">Calculated</span></td>
                                                <td>87.75</td>
                                                <td>83 - 101</td>
                                                <td>fL</td>
                                            </tr>
                                            <tr>
                                                <td>MCH Calculated</td>
                                                <td>27.72</td>
                                                <td>27 - 32</td>
                                                <td>pg</td>
                                            </tr>
                                            <tr>
                                                <td>MCHC Calculated</td>
                                                <td>32.8</td>
                                                <td>32.5 - 34.5</td>
                                                <td>g/dL</td>
                                            </tr>
                                            <tr>
                                                <td>RDW</td>
                                                <td>13.6</td>
                                                <td>11.6 - 14.0</td>
                                                <td>%</td>
                                            </tr>
                                            <tr>
                                                <td class="report-title" colspan="4">WBC COUNT</td>
                                            </tr>
                                            <tr>
                                                <td>Total WBC Count</td>
                                                <td>9000</td>
                                                <td>4000 - 11000</td>
                                                <td>cells/µL</td>
                                            </tr>
                                            <tr>
                                                <td class="report-title" colspan="4">DIFFERENTIAL WBC COUNT</td>
                                            </tr>
                                            <tr>
                                                <td>Neutrophils</td>
                                                <td>60</td>
                                                <td>50 - 62</td>
                                                <td>%</td>
                                            </tr>
                                            <tr>
                                                <td>Lymphocytes</td>
                                                <td>31</td>
                                                <td>20 - 40</td>
                                                <td>%</td>
                                            </tr>
                                            <tr>
                                                <td>Eosinophils</td>
                                                <td>01</td>
                                                <td>00 - 06</td>
                                                <td>%</td>
                                            </tr>
                                            <tr>
                                                <td>Monocytes</td>
                                                <td>07</td>
                                                <td>00 - 10</td>
                                                <td>%</td>
                                            </tr>
                                            <tr>
                                                <td>Basophils</td>
                                                <td>01</td>
                                                <td>00 - 02</td>
                                                <td>%</td>
                                            </tr>
                                            <tr>
                                                <td>Platelet Count</td>
                                                <td>248157</td>
                                                <td>150000 - 410000</td>
                                                <td>µL</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Invoice Item -->

                    <p class="mb-2"><span class="text-gray-9 fw-medium">Instruments :</span> Fully Automated Cell Counter - Mindray 300</p>
                    <p class="mb-3"><span class="text-gray-9 fw-medium">Interpretation :</span> Further confirm for Anemia</p>

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="scan-wrap">
                                <h6>Scan to download report</h6>
                                <img src="assets/img/scan.png" alt="scan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="prescriber-info">
                                <h6>Dr. Edalin Hendry</h6>
                                <p>Dept of Cardiology</p>
                            </div>
                        </div>
                    </div>

                    <ul class="nav inv-paginate justify-content-center">
                        <li>Page 01 of <a href="#" data-bs-toggle="modal" data-bs-target="#view_prescription2" data-bs-dismiss="modal">02</a></li>
                    </ul>
                </div>	
            </div>
        </div>
    </div>
</div>
<!-- /View Report -->

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
                        <li><a href="javascript:void(0);" class="print-link"><i class="isax isax-printer"></i></a></li>
                        <li><a href="#" class="btn btn-primary-gradient rounded-pill">Download</a></li>
                    </ul>							
                </div>
                <div class="view-prescribe invoice-content mb-0">
                    <div class="invoice-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="invoice-logo">
                                    <img src="assets/img/logo.svg" alt="logo">
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
                        <p class="mb-0">An account of the present illness, which includes the circumstances surrounding the onset of recent health changes and the chronology of subsequent events that have led the patient to seek medicine</p>
                    </div>
                    <div class="other-info">
                        <h4>Follow Up</h4>
                        <p class="mb-0">Follow up after 3 months, Have to come on empty stomach</p>
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

<!-- Delete -->
<div class="modal fade custom-modals" id="delete_modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <form action="medical-records.html">
                    <span class="del-icon mb-2 mx-auto">
                        <i class="isax isax-trash"></i>
                    </span>
                    <h3 class="mb-2">Delete Record</h3>
                    <p class="mb-3">Are you sure you want to delete this record?</p>
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <a href="#" class="btn btn-md btn-dark rounded-pill" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-md btn-primary-gradient rounded-pill">Yes Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Delete -->


@endsection