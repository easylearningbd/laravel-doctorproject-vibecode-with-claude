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
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Appointment Date</th>
                        <th>Booked on</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    <tr>
        <td><a href="javascript:void(0);" class="text-blue-600" data-bs-toggle="modal" data-bs-target="#invoice_view">#Inv-2021</a></td>
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
        <td>
            <div class="action-item">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#invoice_view">
                    <i class="isax isax-link-2"></i>
                </a>
                <a href="javascript:void(0);">
                    <i class="isax isax-printer5"></i>
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
 




@endsection
