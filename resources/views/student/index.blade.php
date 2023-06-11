@extends('student/layout/dashboard-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Dashboard')
</head>

<body>
    <div id="app" v-loading.fullscreen.lock="fullscreenLoading">
    @include('student/imports/nav')
        <div class="" v-for="user in student_data">
            <section id="main" class="slide-in">
                <div class="main-container">
                    <div class="profile-avatar">
                        <img class="row justify-content-sm-center border rounded-circle" style="width: 15rem;" :src="user.avatar" alt="Profile" />
                    </div>
                    <h1 class="border-h1 text-uppercase">
                        <span v-text="user.name"></span>
                    </h1>
                    <h3 class="h3-plain mb-5"><span v-text="user.identification"></span></h3>
                </div>
            </section>
        </div>
            <main v-for="user in student_data">
                <section class="records slide-in">
                    <div class="container">
                        <div class="section-title">
                            <h2>Personal Records</h2>
                            <h3 class="text-uppercase">Hi!<span class="ps-3" v-text="user.firstname"></span></h3>
                            <p>Electronic Health Records</p>
                        </div>
                        <div class="card">
                            <div class="card-body content">
                                <h3 class="card-title">Complete Blood Count</h3>
                                <p class="card-text">Text</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body content">
                                <h3 class="card-title">Urinalysis</h3>
                                <p class="card-text">Text</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body content">
                                <h3 class="card-title">Heppa B Vaccine</h3>
                                <p class="card-text">Text</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body content">
                                <h3 class="card-title">Chest X-ray (PA)</h3>
                                <p class="card-text">Text</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body content">
                                <h3 class="card-title">Heppa B Antigen</h3>
                                <p class="card-text">Text</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body content">
                                <h3 class="card-title">Fecalysis</h3>
                                <p class="card-text">Text</p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
    </div>
@include('student/imports/body')
</body>
</html>