

    <header id="header" class="sticky-top home-nav">
        <nav class="navbar">
            <div class="container-fluid d-flex align-items-center">
                <div class="me-3">
                    <img class="w-50 img-fluid rounded-circle" src="<?php echo asset('assets/img/logo.png') ?>" alt="Logo image"> </a>
                </div>
                <div class="nav">
                    <li class="nav-item">
                        <div class="ms-auto mt-auto">
                            <el-dropdown>
                                <el-button class="text-uppercase" type="primary">
                                    Login<i class="ms-2 el-icon-arrow-down el-icon--left"></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <el-link class="dropdown-item" type="primary" :underline="false" @click="studentLogin = true; teacherLogin = false; nurseLogin = false">Student</el-link>
                                    <el-link class="dropdown-item" type="primary":underline="false" @click="teacherLogin = true; studentLogin = false; nurseLogin = false">Teacher</el-link>
                                    <el-link class="dropdown-item" type="primary":underline="false" @click="nurseLogin = true; studentLogin = false; teacherLogin = false">Nurse</el-link>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </div>
                    </li>
                </div>
            </div>
        </nav>
    </header>