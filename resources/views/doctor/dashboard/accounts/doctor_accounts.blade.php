@extends('doctor.doctor_master')
@section('doctor')



 
<div class="accunts-sec">
    <div class="dashboard-header">
        <div class="header-back">									
            <h3>Accounts</h3>
        </div>
    </div>
    <div class="account-details-box">
        <div class="row">
            <div class="col-xxl-6 col-lg-7">
                <div class="account-payment-info">
                    <h4>Statistics</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="payment-amount">
                                <h6><i class="fa-solid fa-file-invoice-dollar text-success"></i>Total Balance</h6>
                                <span>$900</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="payment-amount">
                                <h6><i class="fa-solid fa-money-bill-1 text-orange"></i>Earned</h6>
                                <span>$906</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="payment-amount">
                                <h6><i class="fa-solid fa-circle-question text-pink"></i>Requested</h6>
                                <span>$50</span>
                            </div>
                        </div>
                    </div>
                    <div class="payment-request">
                        <span>Last Payment request : 24 Mar 2023</span>
                        <a href="#payment_request" class="btn btn-primary prime-btn" data-bs-toggle="modal">Request Payment</a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-1 d-lg-none d-xxl-block"></div>
            <div class="col-lg-5">
                <div class="bank-details-info">
                    <h3>Bank Details</h3>
                    <ul>
                        <li>
                            <h6>Bank Name</h6>
                            <h5>Citi Bank Inc</h5>
                        </li>
                        <li>
                            <h6>Account Number</h6>
                            <h5>5396 5250 1908 XXXX</h5>
                        </li>
                        <li>
                            <h6>Branch Name</h6>
                            <h5>London</h5>
                        </li>
                        <li>
                            <h6>Account Name</h6>
                            <h5>Darren</h5>
                        </li>
                    </ul>
                    <div class="edit-detail-link">
    <a href="#account_details" data-bs-toggle="modal">Edit Or Add Account Details</a>
     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="account-detail-table">
                <!-- Tab Menu -->
                <nav class="accounts-tab">
                <ul class="nav nav-tabs-bottom">
                    <li class="nav-item">
                        <a class="nav-link active" href="#pat_accounts" data-bs-toggle="tab">Accounts</a>
                    </li>
                     
                </ul>
            </nav>
            <!-- /Tab Menu -->
            
            <!-- Tab Content -->
            <div class="tab-content pt-0">
                
                <!-- Accounts Tab -->
                <div id="pat_accounts" class="tab-pane fade show active">
                    <ul class="header-list-btns d-inline-block mb-4">
                        <li>
                            <div class="input-block dash-search-input">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                            </div>
                        </li>
                    </ul>
    <div class="custom-new-table">
        <div class="table-responsive">
            <table class="table table-hover table-center mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Requested Date</th>
                        <th>Account No</th>
                        <th>Credited On</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <a href="#"><span class="text-blue">#AC-1234</span></a>
                        </td>
                        <td>24 Mar 2024</td>
                        <td>5396 5250 1908 XXXX</td>
                        <td>26 Mar 2024</td>
                        <td>$300</td>
                        <td>
                            <span class="badge badge-success-bg">Completed</span>
                        </td>
                        <td>
                            <a href="#request_details_modal" class="account-action" data-bs-toggle="modal"><i class="isax isax-link-2"></i></a>
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
                <!-- /Accounts Tab -->
                
                <!-- Refund Request Tab -->
               
                <!-- /Refund Request Tab -->
                    
            </div>
            <!-- Tab Content -->
        </div>
    </div>
</div>
    
 



<!-- Payment Request Moodal -->
<div class="modal fade custom-modal custom-modal-two modal-lg" id="payment_request">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Request <span class="text-danger request-id">Request ID : #RQ-1323</span></h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span><i class="fa-solid fa-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="accounts.html">
                    <div class="input-block input-block-new">
                        <label class="form-label">Request Amount</label>
                        <input type="text" class="form-control">
                    </div>	
                    <div class="input-block input-block-new">
                        <label class="form-label">Description</label>
                        <textarea rows="3" class="form-control"></textarea>
                    </div>	
                    <div class="form-set-button">
                        <button class="btn btn-light" type="button">Cancel</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
<!-- /Payment Request Moodal -->

<!-- Account Details Modal-->
<div class="modal fade custom-modal custom-modal-two modal-lg" id="account_details">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Account Details</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span><i class="fa-solid fa-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="accounts.htm;">
                    <div class="input-block input-block-new">
                        <label class="form-label">Bank Name</label>
                        <input type="text" class="form-control">
                    </div>	
                    <div class="input-block input-block-new">
                        <label class="form-label">Branch Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="input-block input-block-new">
                        <label class="form-label">Account Number</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="input-block input-block-new">
                        <label class="form-label">Account Name</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-set-button">
                        <button class="btn btn-light" type="button">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save Changes</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
<!-- /Account Details Modal-->

<!-- Other Accounts Modal-->
 
<!-- /Other Accounts Modal-->

<!-- Request Completed Modal-->
<div class="modal fade custom-modal custom-modal-two" id="request_details_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Details <span class="badge badge-success-bg">Completed</span></h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span><i class="fa-solid fa-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="completed-request">
                    <ul>
                        <li>
                            <h6>ID</h6>
                            <span>#AC-1234</span>
                        </li>
                        <li>
                            <h6>Requested on</h6>
                            <span>24 Mar 2024</span>
                        </li>
                        <li>
                            <h6>Credited Date</h6>
                            <span>24 Mar 2024</span>
                        </li>
                        <li>
                            <h6>Amount</h6>
                            <span class="text-blue">$300</span>
                        </li>
                    </ul>
                    <div class="bank-detail">
                        <h4>Bank Details</h4>
                        <div class="accont-information">
                            <h6>Name</h6>
                            <span>Citi Bank Inc</span>
                        </div>
                        <div class="accont-information">
                            <h6>Account No</h6>
                            <span>5396 5250 1908 XXXX</span>
                        </div>
                        <div class="accont-information">
                            <h6>Branch</h6>
                            <span>London</span>
                        </div>
                    </div>
                    <div class="request-des">
                        <h4>Reqeust Description</h4>
                        <p>I recently completed a series of dental treatments with Dr.Edalin Hendry, 
                            and I couldn't be more pleased with the results. From my very first appointment.
                        </p>
                    </div>
                    <a href="#" class="btn btn-primary prime-btn w-100" data-bs-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Request Completed Modal-->

<!-- Request Cancel Modal-->
<div class="modal fade custom-modal custom-modal-two" id="request_cancel_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Details <span class="badge badge-danger-bg">Cancelled</span></h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <span><i class="fa-solid fa-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="cancelled-request">
                    <div class="canceled-user-info d-flex align-items-center">
                        <div class="patinet-information">
                            <a href="doctor-upcoming-appointment.html">
                                <img src="assets/img/doctors-dashboard/profile-01.jpg" alt="User Image">
                            </a>
                            <div class="patient-info">
                                <p>#Apt0001</p>
                                <h6><a href="doctor-upcoming-appointment.html">Adrian</a></h6>
                            </div>
                        </div>
                        <div class="email-info">
                            <ul>
                                <li><i class="fa-solid fa-envelope"></i>adran@example.com</li>
                                <li><i class="fa-solid fa-phone"></i>+1 504 368 6874</li>
                            </ul>
                        </div>
                    </div>
                    <div class="cancellation-fees">
                        <h6>Consultation Fees : $200</h6>
                        <div class="cancellation-info">
                            <div class="appointment-type">
                                <p class="md-text">Type of Appointment</p>
                                <p><i class="fa-solid fa-building text-green"></i>Direct Visit</p>
                            </div>
                            <div class="appointment-type">
                                <p class="md-text">Clinic Location</p>
                                <p>Adrian’s Dentistry</p>
                            </div>
                        </div>
                    </div>
                    <div class="cancel-reason">
                        <h5>Reason</h5>
                        <p>I have an urgent surgery, while our Appointment so i am rejecting appointment </p>
                        <span class="text-danger">Cancelled By You on 23 Mar 2024</span>
                    </div>
                    <span class="text-blue refund">Status : Refund Accepted</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Request Cancel Modal-->

@endsection