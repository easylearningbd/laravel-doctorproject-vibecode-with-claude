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
            <select class="select form-control" id="doctorAvailabilitySelect">
                <option value="1" {{ $doctor->is_available ? 'selected' : '' }}>I am Available Now</option>
                <option value="0" {{ !$doctor->is_available ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var sel = document.getElementById('doctorAvailabilitySelect');
        if (!sel) return;
        sel.addEventListener('change', function () {
            fetch('{{ route("doctor.availability") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ is_available: parseInt(this.value) })
            });
        });
    });
    </script>

    <div class="dashboard-widget">
        <nav class="dashboard-menu">
            <ul>
                {{-- Dashboard --}}
                <li class="{{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('doctor.dashboard') }}">
                        <i class="isax isax-category-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Requests --}}
                <li class="{{ request()->routeIs('doctor.requests') ? 'active' : '' }}">
                    <a href="{{ route('doctor.requests') }}">
                        <i class="isax isax-clipboard-tick"></i>
                        <span>Requests</span>
                    </a>
                </li>

                {{-- Appointments --}}
                <li class="{{ request()->routeIs('doctor.appointments') ? 'active' : '' }}">
                    <a href="{{ route('doctor.appointments') }}">
                        <i class="isax isax-calendar-1"></i>
                        <span>Appointments</span>
                    </a>
                </li>

                {{-- My Patients (active for patients list + individual patient detail page) --}}
                <li class="{{ request()->routeIs('doctor.patients', 'patient.details.page') ? 'active' : '' }}">
                    <a href="{{ route('doctor.patients') }}">
                        <i class="fa-solid fa-user-injured"></i>
                        <span>My Patients</span>
                    </a>
                </li>

                {{-- Specialties & Services --}}
                <li class="{{ request()->routeIs('specialities.services') ? 'active' : '' }}">
                    <a href="{{ route('specialities.services') }}">
                        <i class="isax isax-clock"></i>
                        <span>Specialties & Services</span>
                    </a>
                </li>

                {{-- Reviews (no route yet) --}}
                <li class="{{ request()->routeIs('doctor.reviews') ? 'active' : '' }}">
                    <a href="{{ route('doctor.reviews') }}">
                        <i class="isax isax-star-1"></i>
                        <span>Reviews</span>
                    </a>
                </li>

                {{-- Accounts --}}
                <li class="{{ request()->routeIs('doctor.accounts') ? 'active' : '' }}">
                    <a href="{{ route('doctor.accounts') }}">
                        <i class="isax isax-profile-tick"></i>
                        <span>Accounts</span>
                    </a>
                </li>

                {{-- Invoices --}}
                <li class="{{ request()->routeIs('doctor.invoices', 'doctor.invoice.print') ? 'active' : '' }}">
                    <a href="{{ route('doctor.invoices') }}">
                        <i class="isax isax-document-text"></i>
                        <span>Invoices</span>
                    </a>
                </li>

                {{-- Message (no route yet) --}}
              <li class="{{ request()->routeIs('doctor.message') ? 'active' : '' }}">
                    <a href="{{ route('doctor.message') }}">
                        <i class="isax isax-messages-1"></i>
                        <span>Message</span>
                        <small class="unread-msg">0</small>
                    </a>
                </li>

                {{-- Profile Settings (active for all profile sub-pages) --}}
                <li class="{{ request()->routeIs(
                        'doctor.profile',
                        'doctor.experience',
                        'doctor.education',
                        'doctor.clinics',
                        'doctor.hours'
                    ) ? 'active' : '' }}">
                    <a href="{{ route('doctor.profile') }}">
                        <i class="isax isax-setting-2"></i>
                        <span>Profile Settings</span>
                    </a>
                </li>

                {{-- Social Media (no route yet) --}}
                <li>
                    <a href="#">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Social Media</span>
                    </a>
                </li>

                {{-- Change Password --}}
                <li class="{{ request()->routeIs('doctor.change.password') ? 'active' : '' }}">
                    <a href="{{ route('doctor.change.password') }}">
                        <i class="isax isax-key"></i>
                        <span>Change Password</span>
                    </a>
                </li>

                {{-- Logout --}}
                <li>
                    <a href="#" onclick="event.preventDefault();document.getElementById('doctor-logout-form').submit();">
                        <i class="isax isax-logout"></i>
                        <span>Logout</span>
                    </a>
                    <form id="doctor-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</div>
