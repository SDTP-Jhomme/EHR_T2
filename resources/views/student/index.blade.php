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
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-auto">
                                            <label>Appointment</label>
                                        </div>
                                        <div class="col-lg-6 col-md-10">
                                            <el-select v-model="request.appointment" placeholder="Select Medical Appointment">
                                                <el-option
                                                v-for="item in medOptions"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
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
                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col-12">
                                                    <label class="text-center text-success">Complete Blood Count</label>         
                                                </div>
                                                <div class="col-12">                     
                                                    <el-tooltip class="item" effect="dark" content="Complete Blood Count" placement="top">
                                                        <i class="fas fa-folder" style="color: #f8d775; font-size:12rem;" @click="cbcResult = true"></i>
                                                    </el-tooltip>
                                                </div>
                                            </div>                 
                                        </div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center" v-for="antigen in isAntigen" v-if="antigen.student_id == user.id">
                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col-12">
                                                    <label class="text-center text-success">Heppa B Antigen</label>       
                                                </div>
                                                <div class="col-12">    
                                                    <el-tooltip class="item" effect="dark" content="Heppa B Antigen"  placement="top">
                                                        <i class="fas fa-folder" style="color: #f8d775; font-size:12rem;" @click="antigenResult = true"></i>
                                                    </el-tooltip>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"v-for="vaxx in isVaccine" v-if="vaxx.student_id == user.id">
                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col-12">
                                                    <label class="text-center text-success">Heppa B Vaccine</label>       
                                                </div>
                                                <div class="col-12">                                  
                                                    <el-tooltip class="item" effect="dark" content="Heppa B Vaccine" placement="top">
                                                        <i class="fas fa-folder" style="color: #f8d775; font-size:12rem;" @click="vaxxResult = true"></i>
                                                    </el-tooltip>
                                                </div>
                                            </div>               
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"v-for="urine in isUrinalysis" v-if="urine.student_id == user.id">
                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col-12">
                                                    <label class="text-center text-success">Urinalysis</label>        
                                                </div>
                                                <div class="col-12">                                   
                                                    <el-tooltip class="item" effect="dark" content="Urinalysis" placement="top">
                                                        <i class="fas fa-folder" style="color: #f8d775; font-size:12rem;" @click="urineResult = true"></i>
                                                    </el-tooltip>
                                                </div>
                                            </div>           
                                        </div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"v-for="xray in isXray" v-if="xray.student_id == user.id">  
                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col-12">
                                                    <label class="text-center text-success">Chest X-Ray</label>   
                                                </div>
                                                <div class="col-12">                                       
                                                    <el-tooltip class="item" effect="dark" content="Chest X-Ray" placement="top">
                                                        <i class="fas fa-folder" style="color: #f8d775; font-size:12rem;" @click="xrayResult = true"></i>
                                                    </el-tooltip>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-lg-4 col-md-8 d-flex justify-content-center"v-for="fecal in isFecalysis" v-if="fecal.student_id == user.id">
                                            <div class="row justify-content-center align-items-center g-2">
                                                <div class="col-12">
                                                    <label class="text-center text-success">Fecalysis</label>   
                                                </div>
                                                <div class="col-12">                                       
                                                    <el-tooltip class="item" effect="dark" content="Fecalysis" placement="top">
                                                        <i class="fas fa-folder" style="color: #f8d775; font-size:12rem;" @click="fecalResult = true"></i>
                                                    </el-tooltip>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="section-title">
                                        <h3 class="text-uppercase">Appointment History</h3>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date Requested</th>
                                                    <th scope="col">Identification</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Year and Section</th>
                                                    <th scope="col">Requested Schedule</th>
                                                    <th scope="col">Requested Appointment</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="" v-for="data in reqData">
                                                    <td><span v-text="data.created_at"></span></td>
                                                    <td><span v-text="data.identification"></span></td>
                                                    <td><span v-text="data.name"></span></td>
                                                    <td><span v-text="data.yearandsection"></span></td>
                                                    <td><span v-text="data.request_date"></span></td>
                                                    <td><span v-text="data.section"></span></td>
                                                    <td><span v-text="data.med_status"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-12">
                                <label class="form-label"><span v-text="cbc.dataCreated"></span>-<span>Complete Blood Count</span></label>  
                            </div>
                            <div class="col-12">
                                <img :src="cbc.result" class="img-fluid rounded-top w-100" alt="CBC Result">
                            </div>
                        </div>
                    </div>
                </div>
            </el-dialog>
            <!--Antigen Modal -->
            <el-dialog v-for="antigen in isAntigen" :key="antigen.id" :visible.sync="antigenResult" class="w-100">
                <div class="card mb-3">                
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-12">
                                <label class="form-label"><span v-text="antigen.dataCreated"></span>-<span>Heppa B Antigen</span></label> 
                            </div>
                            <div class="col-12">
                                <img  :src="antigen.result" class="img-fluid rounded-top w-100" alt="Antigen Result">
                            </div>
                        </div>
                    </div>
                </div>
            </el-dialog>
            <!--Vaxx Modal -->
            <el-dialog v-for="vaxx in isVaccine" :visible.sync="vaxxResult" class="w-100">
                <div class="card mb-3">                
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-12">
                                <label class="form-label"><span v-text="vaxx.dataCreated"></span>-<span>Heppa B Vaccine</span></label>
                            </div>
                            <div class="col-12">
                                <img :src="vaxx.result" class="img-fluid rounded-top w-100" alt="Vaccine Result">
                            </div>
                        </div>
                    </div>
                </div>
            </el-dialog>
            <!--Fecalysis Modal -->
            <el-dialog v-for="fecal in isFecalysis" :visible.sync="fecalResult" class="w-100">
                <div class="card mb-3">                
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-12">
                                <label class="form-label"><span v-text="fecal.dataCreated"></span>-<span>Fecalysis</span></label>
                            </div>
                            <div class="col-12">
                                <img :src="fecal.result" class="img-fluid rounded-top w-100" alt="Fecalysis Result">
                            </div>
                        </div>
                    </div>
                </div>
            </el-dialog>
            <!--Urinalysis Modal -->
            <el-dialog v-for="urine in isUrinalysis" :visible.sync="urineResult" class="w-100">
                <div class="card mb-3">                
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-12">
                                <label class="form-label"><span v-text="urine.dataCreated"></span>-<span>Urinalysis</span></label>
                            </div>
                            <div class="col-12">
                                <img :src="urine.result" class="img-fluid rounded-top w-100" alt="Urinalysis Result">
                            </div>
                        </div>
                    </div>
                </div>
            </el-dialog>
            <!--x-ray Modal -->
            <el-dialog v-for="xray in isXray" :visible.sync="xrayResult" class="w-100">
                <div class="card mb-3">           
                    <div class="card-body">
                        <div class="row justify-content-center align-items-center g-2">
                            <div class="col-12">
                                <label class="form-label"><span v-text="xray.dataCreated"></span>-<span>Chest X-ray</span></label>
                            </div>
                            <div class="col-12">
                                <img :src="xray.result" class="img-fluid rounded-top w-100" alt="Xray Result">
                            </div>
                        </div>
                    </div>
                </div>
            </el-dialog>
        </main>
    </div>
@include('student/imports/body')
</body>
</html>