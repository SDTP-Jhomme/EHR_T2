
<aside id="sidebar" class="collapse collapse-horizontal show sidebar">
            <ul class="nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('admin-dashboard')}}">
                        <i class="fas fa-th-large pe-2"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('admin-appointments')}}">
                        <i class="fas fa-calendar pe-2"></i>
                        <span class="menu-title">List of Appointments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#Registration" aria-expanded="false" aria-controls="Registration">
                        <i class="fas fa-users pe-2"></i>
                        <span class="menu-title">Registration</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="Registration">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin-admission')}}"><i class="fas fa-user pe-2"></i>Student</a>
                            </li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('nurse')}}"><i class="fas fa-user-nurse pe-2"></i>Nurse</a>
                            </li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('teacher')}}"><i class="fas fa-chalkboard-teacher pe-2"></i>Adviser</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#payment" aria-expanded="false" aria-controls="payment">
                        <i class="fas fa-folder pe-2"></i>
                        <span class="menu-title">Medical Records</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="payment">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('cbcPage')}}"><i class="fas fa-file-medical pe-2"></i>CBC</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('urinalysisPage')}}"><i class="fas fa-file-medical pe-2"></i>Urinalysis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('fecalysisPage')}}"><i class="fas fa-file-medical pe-2"></i>Fecalysis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('xrayPage')}}"><i class="fas fa-file-medical pe-2"></i>X-ray</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('antigenPage')}}"><i class="fas fa-file-medical pe-2"></i>Hepa Antigen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('vaccinePage')}}"><i class="fas fa-file-medical pe-2"></i>Hepa Vaccine</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </aside>