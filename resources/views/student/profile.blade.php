@extends('student/layout/profile-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('student/imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Profile')
</head>

<body>
    <div id="app" v-loading.fullscreen.lock="fullscreenLoading">
    @include('student/imports/nav')
        <el-container v-for="user in student_data">
            <el-main>
                <div class="row justify-content-center align-items-start g-2">
                    <div class="col-lg-3 col-md-7">
                        <h3>Profile</h3>
                        <div class="card py-4 profile shadow">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                <img :src="user.avatar" alt="Profile" class="rounded-circle mb-3">
                                <h4><span v-text = "user.name"></span></h4>
                                <p>Student</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7">
                        <div class="card p-4 shadow">
                            <el-tabs>
                                <el-tab-pane>
                                    <span slot="label">
                                        <h5><i class="el-icon-document"></i> User Profile Info</h5>
                                    </span>
                                    @include('student/profile/profile-info')
                                </el-tab-pane>
                                <el-tab-pane>
                                    <span slot="label">
                                        <h5><i class="el-icon-lock"></i> Change Password</h5>
                                    </span>
                                    @include('student/profile/update-pass')
                                </el-tab-pane>
                            </el-tabs>
                        </div>
                    </div>
                </div>
            </el-main>
        </el-container>
    </div>
@include('student/imports/body')
</body>
</html>