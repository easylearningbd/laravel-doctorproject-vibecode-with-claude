<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
        <ul> 
            <li class="menu-title">
                <span>Main</span>
            </li>
            <li class="{{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                <a href="{{ route('agent.dashboard') }}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ request()->routeIs('agent.appointments') ? 'active' : '' }}">
                <a href="{{ route('agent.appointments') }}"><i class="fe fe-layout"></i> <span>Appointments</span></a>
            </li>
            <li class="{{ request()->routeIs('agent.spcialities') ? 'active' : '' }}">
                <a href="{{ route('agent.spcialities') }}"><i class="fe fe-users"></i> <span>Specialities</span></a>
            </li>
            <li class="{{ request()->routeIs('all.doctors.agent') ? 'active' : '' }}">
                <a href="{{ route('all.doctors.agent') }}"><i class="fe fe-user-plus"></i> <span>Doctors</span></a>
            </li>
            <li class="{{ request()->routeIs('all.patients.agent') ? 'active' : '' }}">
                <a href="{{ route('all.patients.agent') }}"><i class="fe fe-user"></i> <span>Patients</span></a>
            </li>
            <li class="{{ request()->routeIs('agent.reviews') ? 'active' : '' }}">
                <a href="{{ route('agent.reviews') }}"><i class="fe fe-star"></i> <span>Reviews</span></a>
            </li>
            <li class="{{ request()->routeIs('agent.payment.requests') ? 'active' : '' }}">
                <a href="{{ route('agent.payment.requests') }}"><i class="fe fe-layout"></i> <span>Payment Requests</span></a>
            </li>

            <li class="submenu {{ request()->routeIs('agent.manage.*') ? 'active' : '' }}">
                <a href="#"><i class="fe fe-home"></i> <span>Manage Home</span> <span class="menu-arrow"></span></a>
                <ul style="{{ request()->routeIs('agent.manage.*') ? 'display:block;' : 'display:none;' }}">
                    <li class="{{ request()->routeIs('agent.manage.banner') ? 'active' : '' }}">
                        <a href="{{ route('agent.manage.banner') }}">Manage Banner</a>
                    </li>
                    <li class="{{ request()->routeIs('agent.manage.services') ? 'active' : '' }}">
                        <a href="{{ route('agent.manage.services') }}">Manage Services</a>
                    </li>
                    <li class="{{ request()->routeIs('agent.manage.bookus') ? 'active' : '' }}">
                        <a href="{{ route('agent.manage.bookus') }}">Manage Book Us</a>
                    </li>
                    <li class="{{ request()->routeIs('agent.manage.testimonials') ? 'active' : '' }}">
                        <a href="{{ route('agent.manage.testimonials') }}">Manage Testimonials</a>
                    </li>
                    <li class="{{ request()->routeIs('agent.manage.faqs') ? 'active' : '' }}">
                        <a href="{{ route('agent.manage.faqs') }}">Manage FAQs</a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
</div>
</div>
