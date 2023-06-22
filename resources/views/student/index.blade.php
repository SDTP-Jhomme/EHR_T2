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
            <!-- Modal -->
            <el-dialog :visible.sync="openAppointmentDialog" width="40%">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Request Appointment</h5>
                    </div>
                    <div class="modal-body">
                        <el-form ref="form" :model="request" label-width="120px">
                            <div class="row justify-content-start align-items-center g-2">
                                <div class="col-lg-6 col-md-10">
                                    <label>Appointment</label>
                                    <el-select v-model="request.appointment" placeholder="Select Medical Appointment">
                                        <el-option
                                        v-for="item in medOptions"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="col-lg-6 col-md-10">
                                    <label>Request Date</label>
                                    <el-date-picker
                                    v-model="request.date"
                                    type="date"
                                    placeholder="Pick a day" :picker-options="datePickerOptions">
                                    </el-date-picker>
                                </div>
                            </div>
                        </el-form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" :loading="loadButton" class="btn btn-primary" @click="reqAppointment('request')">Send Request</button>
                    </div>
                    </div>
                </div>
            </el-dialog>
        </div>
            <main v-for="user in student_data">
                <section class="records slide-in">
                    <div class="container">
                        <div class="section-title">
                            <h2>Personal Records</h2>
                            <h3 class="text-uppercase">Hi!<span class="ps-3" v-text="user.firstname"></span></h3>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body content">
                                <div class="container">
                                    <div class="row align-items-center g-2 my-2">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Full Name</label>
                                                <input type="text" class="form-control" v-model="user.name" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Year</label>
                                                <input type="text" class="form-control" v-model="user.year" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Section</label>
                                                <input type="text" class="form-control" v-model="user.classSection" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Age</label>
                                                <input type="text" class="form-control" v-model="user.age" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Birthdate</label>
                                                <input type="text" class="form-control" v-model="user.birthdate" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Gender</label>
                                                <input type="text" class="form-control" v-model="user.gender" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control" v-model="user.address" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Citizenship</label>
                                                <input type="text" class="form-control" v-model="user.citizenship" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Civil Status</label>
                                                <input type="text" class="form-control" v-model="user.civil" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"><i class="fas fa-folder" style="color: #f8d775; font-size:15rem;"></i></div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"><i class="fas fa-folder" style="color: #f8d775; font-size:15rem;"></i></div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"><i class="fas fa-folder" style="color: #f8d775; font-size:15rem;"></i></div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"><i class="fas fa-folder" style="color: #f8d775; font-size:15rem;"></i></div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"><i class="fas fa-folder" style="color: #f8d775; font-size:15rem;"></i></div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"><i class="fas fa-folder" style="color: #f8d775; font-size:15rem;"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@include('student/imports/body')
</body>
</html>