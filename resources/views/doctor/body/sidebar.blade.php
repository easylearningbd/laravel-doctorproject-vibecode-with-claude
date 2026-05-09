<div class="profile-sidebar doctor-sidebar profile-sidebar-new">
        <div class="widget-profile pro-widget-content">
            @php $doctor = auth()->user(); @endphp
            <div class="profile-info-widget">
                <a href="{{ route('doctor.profile') }}" class="booking-doc-img">
                    @if ($doctor->profile_photo)
                        <img src="{{ asset('storage/' . $doctor->profile_photo) }}" alt="User Image">
                    @else
                        <img src="{{ asset('backend/assets/img/doctors-dashboard/doctor-profile-img.jpg') }}" alt="User Image">
                    @endif
                </a>
                <div class="profile-det-info">
                    <h3>
                        <a href="{{ route('doctor.profile') }}">
                            Dr {{ $doctor->first_name }} {{ $doctor->last_name }}
                        </a>
                    </h3>
                    <div class="patient-details">
                        <h5 class="mb-0">{{ $doctor->designation ?? 'Doctor' }}</h5>
                    </div>
                    @if ($doctor->specialization)
                        <span class="badge doctor-role-badge">
                            <i class="fa-solid fa-circle"></i>{{ $doctor->specialization }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="doctor-available-head">
            <div class="input-block input-block-new">
                <label class="form-label">Availability <span class="text-danger">*</span></label>
                <select class="select form-control">
                    <option>I am Available Now</option>
                    <option>Not Available</option>
                </select>
            </div>
        </div>
        <div class="dashboard-widget">
            <nav class="dashboard-menu">
                <ul>
                    <li class="active">
                        <a href="doctor-dashboard.html">
                            <i class="isax isax-category-2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.requests') }}">
                            <i class="isax isax-clipboard-tick"></i>
                            <span>Requests</span>
                            <small class="unread-msg">2</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.appointments') }}">
                            <i class="isax isax-calendar-1"></i>
                            <span>Appointments</span>
                        </a>
                    </li>
                     
                    <li>
                        <a href="{{ route('doctor.patients') }}">
                            <i class="fa-solid fa-user-injured"></i>
                            <span>My Patients</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('specialities.services') }}">
                            <i class="isax isax-clock"></i>
                            <span>Specialties & Services</span>
                        </a>
                    </li>
                    <li>
                        <a href="reviews.html">
                            <i class="isax isax-star-1"></i>
                            <span>Reviews</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.accounts') }}">
                            <i class="isax isax-profile-tick"></i>
                            <span>Accounts</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.invoices') }}">
                            <i class="isax isax-document-text"></i>
                            <span>Invoices</span>
                        </a>
                    </li>
                    																																			
                    <li>
                        <a href="chat-doctor.html">
                            <i class="isax isax-messages-1"></i>
                            <span>Message</span>
                            <small class="unread-msg">7</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.profile') }}">
                            <i class="isax isax-setting-2"></i>
                            <span>Profile Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="social-media.html">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Social Media</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctor.change.password') }}">
                            <i class="isax isax-key"></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li>
                        <a href="login.html">
                            <i class="isax isax-logout"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>