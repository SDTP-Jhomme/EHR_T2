<!-- header -->
<header id="header" class="sticky-top nav-bg">
    <nav class="navbar">
        <div class="container-fluid d-flex align-items-center">
            <div class="row justify-content-start align-items-center">
                <div class="col-auto">
                    <a class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="collapse"
                        href="#sidebar" aria-expanded="false" aria-controls="sidebar">
                        <i class="fas fa-bars" style="color: #fff;"></i>
                    </a>
                </div>
                <div class="col-auto">
                    <img class="w-75 img-fluid rounded-circle" src="<?php echo asset('assets/img/logo.png'); ?>" alt="Logo image">
                </div>
                <div class="col-auto">
                    <h4 class="text-light">Electronic Health Record System</h4>
                </div>
            </div>
            <div class="nav">
                <li class="nav-item">
                    <div class="ms-auto d-flex mt-auto">
                        <div class="dropstart user-dropdown">
                            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img class="img-xs rounded-circle" src="<?php echo asset('assets/avatar/default.png'); ?>" alt="Profile image"> </a>
                            <div class="dropdown-menu" aria-labelledby="UserDropdown">
                                <div class="dropdown-header text-center">
                                    <img class="img-md rounded-circle" src="<?php echo asset('assets/avatar/default.png'); ?>" alt="Profile image">
                                    <p class="mb-1 mt-3 fw-light text-muted">Admin</p>
                                </div>
                                <div class="dropdown-item">
                                    <a class="nav-link" href="{{ route('adminLogout') }}">
                                        <i class="fas fa-power-off text-danger me-2"></i>
                                        Sign Out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </div>
        </div>
    </nav>
</header>
