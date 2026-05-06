	<div class="header-topbar">
<div class="container">
    <div class="topbar-info">
        <div class="d-flex align-items-center gap-3 header-info">
            <p><i class="isax isax-message-text5 me-1"></i>info@example.com</p>
            <p><i class="isax isax-call5 me-1"></i>+1 66589 14556</p>
        </div>
        <ul>
            <li class="header-theme">
                <a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle">
                    <i class="isax isax-sun-1"></i>
                </a>
                <a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle activate">
                    <i class="isax isax-moon"></i>
                </a>
            </li>
            <li class="d-inline-flex align-items-center drop-header">
                <div class="dropdown dropdown-country me-3">
                    <a href="javascript:void(0);" class="d-inline-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('backend/assets/img/flags/us-flag.svg') }}" class="me-2" alt="flag">
                    </a>
                    <ul class="dropdown-menu p-2 mt-2">
                        <li>
                            <a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
                                <img src="{{ asset('backend/assets/img/flags/us-flag.svg') }}" class="me-2" alt="flag">ENG
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
                                <img src="assets/img/flags/arab-flag.svg" class="me-2" alt="flag">ARA
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item rounded d-flex align-items-center" href="javascript:void(0);">
                                <img src="{{ asset('backend/assets/img/flags/france-flag.svg') }}" class="me-2" alt="flag">FRA
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown dropdown-amt">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        USD
                    </a>
                    <ul class="dropdown-menu p-2 mt-2">
                        <li><a class="dropdown-item rounded" href="javascript:void(0);">USD</a></li>
                        <li><a class="dropdown-item rounded" href="javascript:void(0);">YEN</a></li>
                        <li><a class="dropdown-item rounded" href="javascript:void(0);">EURO</a></li>
                    </ul>
                </div>
            </li>
            <li class="social-header">
                <div class="social-icon">
                    <a href="javascript:void(0);"><i class="fa-brands fa-facebook"></i></a>
                    <a href="javascript:void(0);"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="javascript:void(0);"><i class="fa-brands fa-instagram"></i></a>
                    <a href="javascript:void(0);"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="javascript:void(0);"><i class="fa-brands fa-pinterest"></i></a>
                </div>
            </li>
        </ul>
    </div>
</div>
</div>

<!-- Header -->
<header class="header header-custom header-fixed inner-header relative">
<div class="container">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a href="index.html" class="navbar-brand logo">
                <img src="{{ asset('backend/assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
            </a>
        </div>
        <div class="header-menu">
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="index.html" class="menu-logo">
                        <img src="{{ asset('backend/assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <ul class="main-nav">
                    <li class="has-submenu megamenu active">
                        <a href="javascript:void(0);">Home  </a>
                            
                    </li>
                    <li class="has-submenu">
                        <a href="javascript:void(0);">Doctors   </a>
                        
                    </li>
                    <li class="has-submenu">
                        <a href="javascript:void(0);">Patients  </a>
                        
                    </li>
                     
                     
                    <li class="has-submenu">
                        <a href="#">Blog  </a>
                        
                    </li>
                    <li class="has-submenu">
                        <a href="#">Contact Us  </a>
                         
                    </li>
                </ul>
            </div>
            <ul class="nav header-navbar-rht">
                <li class="searchbar">
                    <a href="javascript:void(0);"><i class="feather-search"></i></a>
                    <div class="togglesearch">
                        <form action="search.html">
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <button type="submit" class="btn">Search</button>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <a href="login.html" class="btn btn-md btn-primary-gradient d-inline-flex align-items-center rounded-pill"><i class="isax isax-lock-1 me-1"></i>Sign Up</a>
                </li>
                <li>
                    <a href="register.html" class="btn btn-md btn-dark d-inline-flex align-items-center rounded-pill">
                        <i class="isax isax-user-tick me-1"></i>Register
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
</header>