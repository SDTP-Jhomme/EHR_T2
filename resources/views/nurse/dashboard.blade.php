@extends('nurse/layout/dashboard-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('nurse/imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Dashboard')
</head>

<body>
<div id="app">
    <div v-if="fullscreenLoading" class="fullscreen-loading">
        <div class="spinner-heart" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="spinner-text">Loading...</span>
    </div>
@include('nurse/imports/nav')
    <div class="container-fluid page-wrapper">
    @include('nurse/imports/sidebar')
        <main class="main-panel flex-lg-grow-1">
            <el-dialog title="Profile" v-for="data in fetchData" :visible.sync="profile" width="35%"
                :before-close="profileClose">
                <div class="card">
                    <div class="mt-2 d-flex justify-content-center">
                        <el-avatar shape="square" :size="100" :src="data.avatar"></el-avatar>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center g-2 mb-3">
                            <div class="col-lg-3 col-md-12">
                                <label class="form-label">Identification</label>
                                <el-input v-model="data.identification" disabled></el-input>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <label class="form-label">Name</label>
                                <el-input v-model="data.name" disabled></el-input>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <label class="form-label">Gender</label>
                                <el-input v-model="data.gender" disabled></el-input>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <label class="form-label">Birthdate</label>
                                <el-input v-model="data.birthdate" disabled></el-input>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-lg-6 col-md-12">
                                <label class="form-label">Address</label>
                                <el-input v-model="data.address" disabled></el-input>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <label class="form-label">Phone No.</label>
                                <el-input v-model="data.phone_number" disabled></el-input>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center g-2 my-5">
                            <div class="col-12">
                                <el-button class="btn-block" type="primary" @click="changePass = true">Change Password
                                </el-button>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-12" v-if="changePass">
                                <div class="row justify-content-center align-items-center g-2 mb-2" v-if="!checkPass">
                                    <div class="col-12">
                                        <label class="form-label mb-0" for=""><span class="text-danger">*</span>
                                            Current Password</label>
                                        <el-input placeholder="Enter Current Password" v-model="currentPassword"
                                            show-password></el-input>
                                        <span class="text-danger" v-text="currentPassErr"></span>
                                    </div>
                                </div>
                                <div class="" v-else>
                                    <div class="row justify-content-center align-items-center g-2 mb-2">
                                        <div class="col-12">
                                            <label class="form-label mb-0" for=""><span
                                                    class="text-danger">*</span> Input New Password</label>
                                            <el-input placeholder="" v-model="newPassword" show-password></el-input>
                                            <span class="text-danger" v-text="newPassErr"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2 mb-2">
                                        <div class="col-12">
                                            <label class="form-label mb-0" for=""><span
                                                    class="text-danger">*</span> Confirm Password</label>
                                            <el-input placeholder="" v-model="confirmPassword" show-password></el-input>
                                            <span class="text-danger" v-text="confirmPassErr"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center align-items-center g-2 mt-2">
                                    <div class="col-12" v-if="checkPass">
                                        <button class="btn btn-primary" v-if="loadButton" disabled><i class="el-icon-loading"></i> Loading</button>
                                        <button class="btn btn-primary" v-else @click="updatePassword">Update Password</button>
                                        <button class="btn btn-secondary" @click="resetPassword">Reset Form</button>
                                        <button class="btn btn-secondary" @click="cancelUpdatePassword">Cancel</button>
                                    </div>
                                    <div class="col-12" v-else>
                                        <button type="button" class="btn btn-primary" @click="checkPassword">Submit</button>
                                        <button class="btn btn-secondary" @click="changePass=false">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </el-dialog>
            <div class="container-fluid">
                <div class="content-wrapper">
                    <h3>Dashboard</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="home-tab">
                                <div class="row">
                                    <div class="row justify-content-between align-items-center g-2 mb-3">
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/cbc.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Complete Blood Count</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.cbcCount"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/urinalysis.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Urinalysis</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countUrine"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/fecalysis.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Fecalysis</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countfecal"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between align-items-center g-2 mb-4">
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/x-ray.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Chest X-ray (PA)</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countXray"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/hepa-antigen.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Heppa B Antigen</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countAntigen"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/hepa-vaccine.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Heppa B Vaccine</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countVaccine"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row mt-4">
                                        <div class="col-lg-8 d-flex flex-column">
                                            <div class="row flex-grow-1">
                                                <div class="col-12 grid-margin stretch-card">
                                                    <div class="card w-100 rounded">
                                                        <div class="card-body">
                                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                                <div>
                                                                    <h4 class="card-title card-title-dash">Registration Overview</h4>
                                                                    <p class="card-subtitle card-subtitle-dash">Monthly data</p>
                                                                </div>
                                                            </div>
                                                            <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                                <div class="me-3">
                                                                    <div id="marketing-overview-legend"></div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-3">
                                                                <canvas ref="chartCanvas" id="formChart" style="height: 370px; width: 95%;"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-4 d-flex flex-column">
                                            <div class="card w-100 rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start border-bottom">
                                                        <div>
                                                            <h4 class="card-title card-title-dash text-muted">Medical Records Overview</h4>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <canvas ref="chartPie"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</div>
</div>
</body>

</html>