<!DOCTYPE html>
<html lang="en">
@extends('admin/layout/login-layout')

<head>
    @section('title', 'Admin-Login')
</head>

<body>
    @section('content')
    <section id="login-main" class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 right-fade-in">
                    <form class="form-box" id="login-form" action="{{route('admin-loginPost')}}" method="post">
                        @csrf
                        <h4 class="float-start text-dark mb-4">Sign In</h4>
                        <div class="form-group mb-4">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                            <div class="d-flex justify-content-center">
                                <span class="text-danger fst-italic error" id="username-error"></span>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <button type="button" class="input-group-text" onclick="showPassword()">
                                    <span class="fw-bold show-pass text-muted">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <span class="text-danger fst-italic error" id="password-error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="btn-login" class="btn-login" onclick="login()">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
@endsection

</html>