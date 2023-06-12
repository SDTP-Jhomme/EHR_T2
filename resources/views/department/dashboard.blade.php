@extends('department/layout/dashboard-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Dashboard')
</head>

<body>
    <div id="app" v-loading.fullscreen.lock="fullscreenLoading">
    @include('department/imports/nav')
    </div>
@include('student/imports/body')
</body>
</html>