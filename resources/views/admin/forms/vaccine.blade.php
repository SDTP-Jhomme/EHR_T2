@extends('admin/layout/vaccine-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('storage/assets/img/favicon.png') ?>">
    @section('title', 'Vaccine-form')
</head>

<body>
    @section('content')
    <div class="container-fluid" v-if="this.isVaccine">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Heppa B Vaccine</h4>
                        <div class="row align-items-center g-2 my-2">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" v-model="this.firstname" disabled />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" v-model="midname" disabled />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" v-model="lastname" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center g-2 my-2">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Age</label>
                                    <input type="text" class="form-control" v-model="this.age" disabled />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Gender</label>
                                    <input type="text" class="form-control" v-model="gender" disabled />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <form class="mb-4" @submit.prevent="submitVaccine">
                            @csrf
                            <div class="row align-items-center g-2 my-2">
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Vaccination Date:</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" v-model="formattedDate" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Vaccine Batch:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" v-model="vaccineBatch"/>
                                        </div>
                                        <div class="text-danger" v-text="errors.vaccineBatch"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Healthcare Provider:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" v-model="healthcareProvider"/>
                                        </div>
                                        <div class="text-danger" v-text="errors.healthcareProvider"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                                <button class="btn btn-outline-primary btn-sm" type="submit">Submit <i class="fas fa-arrow-circle-right ps-2"></i></button>
                            </div>
                            <div class="mt-2 mb-4">
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col">
                                        <div class="progress" :space="800" :active="active" finish-status="success">
                                            <div class="progress-bar bg-success" title="Step Finish" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Finish</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endsection
</body>
</html>