@extends('student/layout/profile-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Profile')
</head>

<body>
    <div id="app" v-loading.fullscreen.lock="fullscreenLoading">
    @include('student/imports/nav')
        <el-container v-for="user in student_data">
            <el-header height="0px"></el-header>
            <el-main>
                <el-row class="mb-3">
                    <el-col :span="12" :offset="2">
                        <h3>Profile</h3>
                    </el-col>
                </el-row>
                <el-row :gutter="30" class="mb-3" type="flex" justify="center">
                    <el-col :span="6">
                        <div class="card profile shadow">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                <img :src="user.avatar" alt="Profile" class="rounded-circle mb-3">
                                <h4><span v-text = "user.name"></span></h4>
                                <p>Student</p>
                            </div>
                        </div>
                    </el-col>
                    <el-col :span="12">
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
                    </el-col>
                </el-row>
            </el-main>
        </el-container>
    </div>
@include('student/imports/body')
</body>
</html>