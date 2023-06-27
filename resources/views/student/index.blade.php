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
                <div class="card">
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
                                    type="datetime"
                                    default-time="8:00:00"
                                    placeholder="Select day and time" :picker-options="datePickerOptions">
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
                            <div class="card">
                                <div class="card-body">
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
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="section-title">
                                        <h3 class="text-uppercase">Medical Records</h3>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center" v-for="cbc in isCbc" :key="cbc.id" v-if="cbc.student_id == user.id">
                                            <label class="text-center text-success">Complete Blood Count</label>                                 
                                            <el-tooltip class="item" effect="dark" content="Complete Blood Count" placement="top">
                                                <i class="fas fa-folder" style="color: #f8d775; font-size:15rem;" @click="cbcResult = true"></i>
                                            </el-tooltip>
                                        </div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center" v-for="antigen in isAntigen" v-if="antigen.student_id == user.id">
                                            <label class="text-center text-success">Heppa B Antigen</label>
                                            <el-tooltip class="item" effect="dark" content="Heppa B Antigen"  placement="top">
                                                <i class="fas fa-folder" style="color: #f8d775; font-size:15rem;" @click="antigenResult = true"></i>
                                            </el-tooltip>
                                        </div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"v-for="vaxx in isVaccine" v-if="vaxx.student_id == user.id">
                                            <label class="text-center text-success">Heppa B Vaccine</label>                                      
                                            <el-tooltip class="item" effect="dark" content="Heppa B Vaccine" placement="top">
                                                <i class="fas fa-folder" style="color: #f8d775; font-size:15rem;" @click="vaxxResult = true"></i>
                                            </el-tooltip>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"v-for="urine in isUrinalysis" v-if="urine.student_id == user.id">
                                            <label class="text-center text-success">Urinalysis</label>                                           
                                            <el-tooltip class="item" effect="dark" content="Urinalysis" placement="top">
                                                <i class="fas fa-folder" style="color: #f8d775; font-size:15rem;" @click="urineResult = true"></i>
                                            </el-tooltip>
                                        </div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"v-for="xray in isXray" v-if="xray.student_id == user.id">
                                            <label class="text-center text-success">Chest X-ray</label>                                   
                                            <el-tooltip class="item" effect="dark" content="Chest X-ray" placement="top">
                                                <i class="fas fa-folder" style="color: #f8d775; font-size:15rem;" @click="xrayResult = true"></i>
                                            </el-tooltip>
                                        </div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"v-for="fecal in isFecalysis" v-if="fecal.student_id == user.id">
                                            <label class="text-center text-success">Fecalysis</label>                                          
                                            <el-tooltip class="item" effect="dark" content="Fecalysis" placement="top">
                                                <i class="fas fa-folder" style="color: #f8d775; font-size:15rem;" @click="fecalResult = true"></i>
                                            </el-tooltip>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
            </section>
            <!--CBC Modal -->
            <el-dialog v-for="cbc in isCbc" :visible.sync="cbcResult" class="w-100">
                <div class="card mb-3">
                    <div class="card-body">
                        <label class="form-label"><span v-text="cbc.dataCreated"></span>-<span>Complete Blood Count</span></label>
                        <img :src="cbc.result" class="img-fluid rounded-top" alt="CBC Result">
                    </div>
                </div>
            </el-dialog>
            <!--Antigen Modal -->
            <el-dialog v-for="antigen in isAntigen" :key="antigen.id" :visible.sync="antigenResult" class="w-100">
                <div class="card mb-3">                
                    <div class="card-body">
                        <label class="form-label"><span v-text="antigen.dataCreated"></span>-<span>Heppa B Antigen</span></label>
                        <img  :src="antigen.result" class="img-fluid rounded-top" alt="Antigen Result">
                    </div>
                </div>
            </el-dialog>
            <!--Vaxx Modal -->
            <el-dialog :visible.sync="vaxxResult" class="w-100">
                <div v-for="vaxx in isVaccine" class="card mb-3">                
                    <div class="card-body">
                        <label class="form-label"><span v-text="vaxx.dataCreated"></span>-<span>Heppa B Vaccine</span></label>
                        <img :src="vaxx.result" class="img-fluid rounded-top" alt="Vaccine Result">
                    </div>
                </div>
            </el-dialog>
            <!--Fecalysis Modal -->
            <el-dialog :visible.sync="fecalResult" class="w-100">
                <div v-for="fecal in isFecalysis" class="card mb-3">                
                    <div class="card-body">
                        <label class="form-label"><span v-text="fecal.dataCreated"></span>-<span>Fecalysis</span></label>
                        <img :src="fecal.result" class="img-fluid rounded-top" alt="Fecalysis Result">
                    </div>
                </div>
            </el-dialog>
            <!--Urinalysis Modal -->
            <el-dialog :visible.sync="urineResult" class="w-100">
                <div v-for="urine in isUrinalysis" class="card mb-3">                
                    <div class="card-body">
                        <label class="form-label"><span v-text="urine.dataCreated"></span>-<span>Urinalysis</span></label>
                        <img :src="urine.result" class="img-fluid rounded-top" alt="Urinalysis Result">
                    </div>
                </div>
            </el-dialog>
            <!--x-ray Modal -->
            <el-dialog :visible.sync="xrayResult" class="w-100">
                <div v-for="xray in isXray" class="card mb-3">           
                    <div class="card-body">
                        <label class="form-label"><span v-text="xray.dataCreated"></span>-<span>Chest X-ray</span></label>
                        <img :src="xray.result" class="img-fluid rounded-top" alt="Xray Result">
                    </div>
                </div>
            </el-dialog>
        </main>
    </div>
@include('student/imports/body')
</body>
</html>