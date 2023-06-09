<!-- header -->
<header v-for="user in student_data" :key="user.id" id="header" class="sticky-top header-bg ">
    <nav class="navbar">
        <div class="container-fluid d-flex align-items-center">
            <div class="row justify-content-start align-items-center">
                <div class="col-auto">
                    <img class="w-75 img-fluid rounded-circle" src="<?php echo asset('assets/img/logo.png'); ?>" alt="Logo image">
                </div>
                <div class="col-auto d-none d-lg-block">
                    <h4 class="text-dark">Electronic Health Record System</h4>
                </div>
            </div>
            <div class="nav">
                <li class="nav-item home-div" v-if="backToHome">
                    <a class="nav-link home-link" href="{{ route('student-dashboard') }}">
                        Back To Home
                    </a>
                </li>
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item">
                    <div class="ms-auto mt-auto">
                        <div class="dropstart user-dropdown">
                            <a class="btn btn-outline-success rounded-circle mx-4" id="UserDropdown" href="#"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="UserDropdown">
                                <div class="dropdown-header text-center">
                                    <p>Logged in as:</p>
                                    <el-tag type="success"><span v-text="user.identification"></span></el-tag>
                                </div>
                                <hr>
                                <div class="dropdown-item">
                                    <a class="nav-link" type="button" @click="openAppointmentDialog = true">
                                        <i class="el-icon-date text-muted me-2"></i>
                                        Request Appointment
                                    </a>
                                </div>
                                <hr>
                                <div class="dropdown-item">
                                    <a class="nav-link" href="{{ route('studentprofile') }}">
                                        <i class="fas fa-user text-muted me-2"></i>
                                        Profile
                                    </a>
                                </div>
                                <hr>
                                <div class="dropdown-item">
                                    <a class="nav-link" href="#" @click="logout">
                                        <i class="fas fa-power-off text-muted me-2"></i>
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
