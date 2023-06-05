<!DOCTYPE html>
<html lang="en">
@extends('admin/layout/login-layout')

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('storage/assets/img/favicon.png') ?>">
    @section('title', 'Admin-Login')
</head>

<body>
    @section('content')
    <section id="login-main" class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 right-fade-in">
                    <div class="form-group mb-4">
                        <input v-on:keyup.enter="login" type="text" id="username" class="form-control" placeholder="Username" :class="{'has-error': this.userErr}" v-model="username" />
                        <div class="d-flex justify-content-center">
                            <span class="text-danger fst-italic error" v-text="userErr"></span>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="input-group">
                            <input v-on:keyup.enter="login" :type="type" id="password" placeholder="Password" class="form-control" :class="{'has-error': this.passErr}" v-model="password" />
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
                        <div class="d-flex justify-content-center">
                            <span class="text-danger fst-italic error" v-text="passErr"></span>
                        </div>
                    </div>

                    <div class="text-center pt-1 mb-5 pb-1 d-grid gap-2">
                        <button type="submit" id="btn-login btn-block" class="btn-login" @click="login">Sign In</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
@endsection

</html>