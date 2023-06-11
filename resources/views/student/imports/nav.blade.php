
    <!-- header -->
    <header v-for="user in student_data" :key="user.id" id="header" class="sticky-top header-bg ">
        <nav class="navbar">
            <div class="container-fluid d-flex align-items-center">
                <div class="mx-4">
                    <img class="w-50 img-fluid rounded-circle" src="<?php echo asset('assets/img/logo.png') ?>" alt="Logo image"> </a>
                </div>
                <div class="nav">
                    <li class="nav-item">
                        <div class="ms-auto mt-auto">
                            <div class="dropstart user-dropdown">
                                <a class="btn btn-outline-success rounded-circle mx-4" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="UserDropdown">
                                    <div class="dropdown-header text-center">
                                        <p>Logged in as:</p>
                                        <el-tag type="success"><span v-text="user.identification"></span></el-tag>
                                    </div>
                                    <div class="dropdown-item">
                                        <a class="nav-link" href="#" @click="logout">
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