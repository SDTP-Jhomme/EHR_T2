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
                        </div>
                        <div v-for="cbc in isCbc" v-if="cbc.student_id === user.id" class="card mb-3">
                            <div class="card-body content">
                                <h3 class="card-title">Complete Blood Count</h3>
                                <div class="container">
                                    <div class="row align-items-center g-2 my-2">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" v-model="user.name" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Age</label>
                                                <input type="text" class="form-control" v-model="cbc.age" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Gender</label>
                                                <input type="text" class="form-control" v-model="user.gender" disabled />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Address</label>
                                                <input type="text" class="form-control" v-model="user.address" disabled />
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row align-items-center g-2 my-2">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Hemoglobin:</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="cbc.hemoglobin" disabled/>
                                                    <span class="input-group-text">g/dL</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Hematocrit:</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="cbc.hematocrit" disabled/>
                                                    <span class="input-group-text">% </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">White Blood Cell Count (WBC):</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="cbc.wbc" disabled/>
                                                    <span class="input-group-text">x 10^9/L</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center g-2 my-2">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label"> Red Blood Cell Count (RBC):</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="cbc.rbc" disabled/>
                                                    <span class="input-group-text">x 10^12/L</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label"> Mean Corpuscular Volume (MCV):</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="cbc.mcv" disabled/>
                                                    <span class="input-group-text">fL</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label"> Mean Corpuscular Hemoglobin (MCH):</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="cbc.mch" disabled/>
                                                    <span class="input-group-text">pg</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center g-2 my-2">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Mean Corpuscular Hemoglobin Concentration (MCHC):</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="cbc.mchc" disabled/>
                                                    <span class="input-group-text"> g/dL</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group mb-4">
                                                <label class="form-label">Platelet Count:</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" v-model="cbc.platelet" disabled/>
                                                    <span class="input-group-text">x 10^9/L</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-for="urinalysis in isUrinalysis" v-if="urinalysis.student_id === user.id" class="card mb-3">
                            <div class="card-body content">
                                <h3 class="card-title">Urinalysis</h3>
                                    <div class="container">
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" v-model="user.name" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Age</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.age" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Gender</label>
                                                    <input type="text" class="form-control" v-model="user.gender" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" v-model="user.address" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Date of request:</label>
                                                    <input type="date" class="form-control" v-model="urinalysis.requestDate" disabled />
                                                </div>
                                            </div>
                                            <h5 class="text-success">PHYSICAL PROPERTIES</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Color:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.color" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Transparency:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.transparency" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Specific Gravity:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.gravity" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center g-2 my-2">
                                            <h5 class="text-success">CHEMICAL ANALYSIS</h5>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Ph:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.ph"disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Sugar:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.sugar" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Protein:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.protein"disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Pregnancy Test:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.pregnancy" disabled/>
                                                </div>
                                            </div>
                                            <h5 class="text-success">MICROSCOPIC EXAMINATION</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Pus cells:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.pus" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">RBC:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.rbc" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Cast:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.cast" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center g-2 my-2">
                                            <h5 class="text-success">CRYSTAL</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Urates:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.urates" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Uric Acid:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.uric" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Cal Ox:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.cal" disabled/>
                                                </div>
                                            </div>
                                            <h5 class="text-success">OTHERS</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Epith Cells:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.epith" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Mucus Threads:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.mucus" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Others:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.otherOthers" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Pathologist:</label>
                                                    <input type="text" class="form-control" v-model="urinalysis.pathologist" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Medical Technologist:</label>
                                                        <input type="text" class="form-control" v-model="urinalysis.technologist" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div v-for="vaccine in isVaccine" v-if="vaccine.student_id === user.id" class="card mb-3">
                                <div class="card-body content">
                                    <h3 class="card-title">Heppa B Vaccine</h3>
                                    <div class="container">
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" v-model="user.name" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Age</label>
                                                    <input type="text" class="form-control" v-model="vaccine.age" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Gender</label>
                                                    <input type="text" class="form-control" v-model="user.gender" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" v-model="user.address" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Vaccination Date:</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" v-model="vaccine.vaccinationDate" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Vaccine Batch:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" v-model="vaccine.vaccineBatch"disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Healthcare Provider:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" v-model="vaccine.healthcareProvider"disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-for="xray in isXray" v-if="xray.student_id == user.id" class="card mb-3">
                                <div class="card-body content">
                                    <h3 class="card-title">Chest X-ray (PA)</h3>
                                    <div class="container">
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" v-model="user.name" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Age</label>
                                                    <input type="text" class="form-control" v-model="xray.age" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Gender</label>
                                                    <input type="text" class="form-control" v-model="user.gender" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" v-model="user.address" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Case No.:</label>
                                                    <input type="text" class="form-control" v-model="xray.case_No" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Referred by:ICHC</label>
                                                    <input type="text" class="form-control" v-model="xray.referred_by" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Room & Bed No:</label>
                                                    <input type="text" class="form-control" v-model="xray.room_bed" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Clinical Impression:</label>
                                                    <input type="text" class="form-control" v-model="xray.clinical_impression" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Type of Examination:</label>
                                                    <input type="text" class="form-control" v-model="xray.type_examination" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-for="antigen in isAntigen" v-if="antigen.student_id === user.id" class="card mb-3">
                                <div class="card-body content">
                                    <h3 class="card-title">Heppa B Antigen</h3>
                                    <div class="container">
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" v-model="user.name" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Age</label>
                                                    <input type="text" class="form-control" v-model="antigen.age" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Gender</label>
                                                    <input type="text" class="form-control" v-model="user.gender" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" v-model="user.address" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row justify-content-center align-items-center g-2 my-2">
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Sample Date:</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" v-model="antigen.sampleDate" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Result:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" v-model="antigen.result"disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-for="fecalysis in isFecalysis" v-if="fecalysis.student_id === user.id" class="card mb-3">
                                <div class="card-body content">
                                    <h3 class="card-title">Fecalysis</h3>
                                    <div class="container">
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control" v-model="user.name" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Age</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.age" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Gender</label>
                                                    <input type="text" class="form-control" v-model="user.gender" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" v-model="user.address" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Requested By:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.requestBy" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Date of request:</label>
                                                    <input type="date" class="form-control" v-model="fecalysis.requestDate" disabled />
                                                </div>
                                            </div>
                                            <h5 class="text-success">PHYSICAL PROPERTIES</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Color:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.color" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Consistency:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.consistency" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center g-2 my-2">
                                            <h5 class="text-success">CHEMICAL PROPERTIES</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Occult Blood:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.occult"disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Others:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.otherOccult" disabled/>
                                                </div>
                                            </div>
                                            <h5 class="text-success">MICROSCOPIC FINDINGS</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Pus cells:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.pus" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">RBC:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.rbc" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Fat GLobules:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.fat" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center g-2 my-2">
                                            <h5 class="text-success">HELMINTHS</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Ova:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.ova" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Larva:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.larva" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Adult Forms:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.adult" disabled/>
                                                </div>
                                            </div>
                                            <h5 class="text-success">PROTOZOA</h5>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Cyst:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.cyst" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Trophozoites:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.trophozoites" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Others:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.otherTrophozoites" disabled/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-4">
                                            <h5 class="text-dark">REMARKS</h5>
                                            <textarea type="text" class="form-control" v-model="fecalysis.remarks"disabled></textarea>
                                        </div>
                                        <div class="row align-items-center g-2 my-2">
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Pathologist:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.pathologist" disabled/>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group mb-4">
                                                    <label class="form-label">Medical Technologist:</label>
                                                    <input type="text" class="form-control" v-model="fecalysis.technologist" disabled/>
                                                </div>
                                            </div>
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