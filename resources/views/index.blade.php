<!DOCTYPE html>
<html lang="en">
@extends('login-layout')

<head>
    @include('imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png'); ?>">
    @section('title', 'Login')
</head>

<body>
    <div id="app" v-loading.fullscreen.lock="fullscreenLoading">
        @include('imports/nav')
        <section id="main" class="slide-in">
            <div class="main-container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-12 col-md-10 col-sm-12">
                        <div class="row row-cols-2 align-items-center g-2">
                            <div class="col-lg-6 col-md-12 col-sm-12 d-none d-sm-none d-lg-block left-fade-in">
                                <h1 class="header-1">
                                    Learn From The Expert
                                </h1>
                                <h3 class="header-3">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime ipsa nulla sed quis
                                    rerum amet
                                    natus quas necessitatibus
                                </h3>
                            </div>
                            <div class="col-lg-5 col-md-12 col-sm-12 col-12 right-fade-in">
                                <!-- student login -->
                                <div class="card" v-if="studentLogin">
                                    <div class="card-body p-md-5 mx-md-4">
                                        <div class="text-center">
                                            <img src="<?php echo asset('assets/img/logo.png'); ?>" style="width: 110px;" alt="logo">
                                            <h4 class="mt-2 mb-4 pb-1">Student Login</h4>
                                        </div>
                                        <label class="form-label" for="studentIdentification">Identification No.</label>
                                        <div class="form-outline">
                                            <input v-on:keyup.enter="nurse_Login" type="text"
                                                id="studentIdentification" class="form-control"
                                                :class="{ 'has-error': this.userErr }"
                                                v-model="studentIdentification" />
                                        </div>
                                        <div class="">
                                            <span class="text-danger fst-italic error" v-text="userErr"></span>
                                        </div>
                                        <label class="form-label mt-4" for="password">Password</label>
                                        <div class="form-outline input-group">
                                            <input v-on:keyup.enter="student_Login" :type="type" id="password"
                                                class="form-control" :class="{ 'has-error': this.passErr }"
                                                v-model="password" />
                                            <button class="input-group-text" @click="showPassword"
                                                v-if="type == 'password'">
                                                <span>
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </button>
                                            <button class="input-group-text" @click="hidePassword"
                                                v-if="type == 'text'">
                                                <span>
                                                    <i class="fa fa-eye-slash"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="mb-5">
                                            <span class="text-danger fst-italic error" v-text="passErr"></span>
                                        </div>
                                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                                            <button @click="student_Login"
                                                class="font-style py-2 btn btn-primary gradient-custom-2 text-uppercase btn-block fa-lg mb-3"
                                                type="submit">Login</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- teacher login -->
                                <div class="card" v-if="teacherLogin">
                                    <div class="card-body p-md-5 mx-md-4">
                                        <div class="text-center">
                                            <img src="<?php echo asset('assets/img/logo.png'); ?>" style="width: 110px;" alt="logo">
                                            <h4 class="mt-2 mb-4 pb-1">Teacher Login</h4>
                                        </div>
                                        <label class="form-label" for="email">Email Address</label>
                                        <div class="form-outline">
                                            <input v-on:keyup.enter="teacher_Login" type="text" id="email"
                                                class="form-control" :class="{ 'has-error': this.userErr }"
                                                v-model="email" />
                                        </div>
                                        <div class="">
                                            <span class="text-danger fst-italic error" v-text="userErr"></span>
                                        </div>
                                        <label class="form-label mt-4" for="password">Password</label>
                                        <div class="form-outline input-group">
                                            <input v-on:keyup.enter="teacher_Login" :type="type"
                                                id="password" class="form-control"
                                                :class="{ 'has-error': this.passErr }" v-model="password" />
                                            <button class="input-group-text" @click="showPassword"
                                                v-if="type == 'password'">
                                                <span>
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </button>
                                            <button class="input-group-text" @click="hidePassword"
                                                v-if="type == 'text'">
                                                <span>
                                                    <i class="fa fa-eye-slash"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="mb-5">
                                            <span class="text-danger fst-italic error" v-text="passErr"></span>
                                        </div>
                                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                                            <button @click="teacher_Login"
                                                class="font-style py-2 btn btn-primary gradient-custom-2 text-uppercase btn-block fa-lg mb-3"
                                                type="submit">Login</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- nurse login -->
                                <div class="card" v-if="nurseLogin">
                                    <div class="card-body p-md-5 mx-md-4">
                                        <div class="text-center">
                                            <img src="<?php echo asset('assets/img/logo.png'); ?>" style="width: 110px;" alt="logo">
                                            <h4 class="mt-2 mb-4 pb-1">Nurse Login</h4>
                                        </div>
                                        <label class="form-label" for="nurseIdentification">Identification No.</label>
                                        <div class="form-outline">
                                            <input v-on:keyup.enter="nurse_Login" type="text"
                                                id="nurseIdentification" class="form-control"
                                                :class="{ 'has-error': this.userErr }" v-model="nurseIdentification" />
                                        </div>
                                        <div class="">
                                            <span class="text-danger fst-italic error" v-text="userErr"></span>
                                        </div>
                                        <label class="form-label mt-4" for="password">Password</label>
                                        <div class="form-outline input-group">
                                            <input v-on:keyup.enter="nurse_Login" :type="type"
                                                id="password" class="form-control"
                                                :class="{ 'has-error': this.passErr }" v-model="password" />
                                            <button class="input-group-text" @click="showPassword"
                                                v-if="type == 'password'">
                                                <span>
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </button>
                                            <button class="input-group-text" @click="hidePassword"
                                                v-if="type == 'text'">
                                                <span>
                                                    <i class="fa fa-eye-slash"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="mb-5">
                                            <span class="text-danger fst-italic error" v-text="passErr"></span>
                                        </div>
                                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                                            <button @click="nurse_Login"
                                                class="font-style py-2 btn btn-primary gradient-custom-2 text-uppercase btn-block fa-lg mb-3"
                                                type="submit">Login</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Electronic Health Record <?php echo date('Y'); ?> </div>
                    <div>All Rigths Reserved</div>
                </div>
            </div>
        </footer>
    </div>
</body>
@include('imports/body')

</html>
