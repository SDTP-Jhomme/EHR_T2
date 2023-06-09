<aside id="sidebar" class="collapse collapse-horizontal show sidebar">
    <ul class="nav">
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('nurse-dashboard') }}">
                <i class="fas fa-th-large pe-2"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('nurse-appointments') }}">
                <i class="fas fa-calendar pe-2"></i>
                <span class="menu-title">List of Appointments<span class="badge bg-primary ms-2 rounded"
                        v-text="pendingReq"></span>
                </span>
            </a>
        </li>
        <!-- <li class="nav-item nav-category">Admissions</li> -->
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#students" aria-expanded="false"
                aria-controls="students">
                <i class="fas fa-users pe-2"></i>
                <span class="menu-title">Students</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="students">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('nurse-admission') }}"><i
                                class="fas fa-user pe-2"></i>Student Records</a>
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
                        <a class="nav-link" href="{{ route('cbc_Page') }}"><i
                                class="fas fa-file-medical pe-2"></i>CBC</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('urinalysis_Page') }}"><i
                                class="fas fa-file-medical pe-2"></i>Urinalysis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('fecalysis_Page') }}"><i
                                class="fas fa-file-medical pe-2"></i>Fecalysis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('xray_Page') }}"><i
                                class="fas fa-file-medical pe-2"></i>Chest X-ray(PA)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('antigen_Page') }}"><i
                                class="fas fa-file-medical pe-2"></i>Heppa B Antigen</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vaccine_Page') }}"><i
                                class="fas fa-file-medical pe-2"></i>Heppa B Vaccine</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</aside>
