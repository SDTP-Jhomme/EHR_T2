@extends('student/layout/dashboard-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('storage/assets/img/favicon.png') ?>">
    @section('title', 'Dashboard')
</head>

<body>
    <div id="app" v-loading.fullscreen.lock="fullscreenLoading">
    @include('student/imports/nav')
        <section id="main" class="slide-in">
            <div class="main-container">
                <h1 class="border-h1">
                Welcome to <strong>Philippine National Police Blotter Report</strong>
                </h1>
                <h3 class="h3-plain mb-5">MOTTO: to SERVE and to PROTECT</h3>
            </div>
        </section>
    </div>
@include('student/imports/body')
</body>
</html>