<!DOCTYPE html>
<html lang="en">
@extends('login-layout')

<head>
@include('imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Login')
</head>

<body>
<div id="app" v-loading.fullscreen.lock="fullscreenLoading">
        <section class="h-100 gradient-form" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center g-0 h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="card-body p-md-5 mx-md-4">

                                        <div class="text-center">
                                            <img src="<?php echo asset('assets/img/logo.png') ?>" style="width: 110px;" alt="logo">
                                            <h4 class="mt-2 mb-4 pb-1">User Login</h4>
                                        </div>

                                        <label class="form-label" for="identification">Identification No.</label>
                                        <div class="form-outline">
                                            <input v-on:keyup.enter="login" type="text" id="identification" class="form-control" :class="{'has-error': this.userErr}" v-model="identification" />
                                        </div>
                                        <div class="">
                                            <span class="text-danger fst-italic error" v-text="userErr"></span>
                                        </div>

                                        <label class="form-label mt-4" for="password">Password</label>
                                        <div class="form-outline input-group">
                                            <input v-on:keyup.enter="login" :type="type" id="password" class="form-control" :class="{'has-error': this.passErr}" v-model="password" />
                                            <button class="input-group-text" @click="showPassword" v-if="type == 'password'">
                                                <span>
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </button>
                                            <button class="input-group-text" @click="hidePassword" v-if="type == 'text'">
                                                <span>
                                                    <i class="fa fa-eye-slash"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="mb-5">
                                            <span class="text-danger fst-italic error" v-text="passErr"></span>
                                        </div>
                                        <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                                            <button @click="login" class="font-style py-2 btn btn-primary gradient-custom-2 text-uppercase btn-block fa-lg mb-3" type="submit">Login</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                        <h4 class="mb-4">Electronic Health Record</h4>
                                        <p class="small mb-0">Software Development Training Program - NOLITC <?php echo date("Y")?></p>
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
                    <div class="text-muted">Copyright &copy; Electronic Health Record <?php echo date("Y"); ?> </div>
                    <div>All Rigths Reserved</div>
                </div>
            </div>
        </footer>
    </div>
</body>
@include('imports/body')

</html>