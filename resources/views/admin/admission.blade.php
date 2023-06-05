@extends('admin/layout/admission-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('storage/assets/img/favicon.png') ?>">
    @section('title', 'Admission')
</head>

<body>
    @section('sidebar')
    <main class="main-panel flex-lg-grow-1">
        <div class="container-fluid">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">
                            <div class="row">
                                <div class="row">
                                    <div class="col-lg-8 d-flex flex-column">
                                        <div class="row flex-grow">
                                            <div class="col-12 grid-margin stretch-card">
                                                <div class="card w-100 rounded">
                                                    <div class="card-body">
                                                        <div class="d-sm-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h4 class="card-title card-title-dash">Clients Overview
                                                                </h4>
                                                                <p class="card-subtitle card-subtitle-dash">Lorem ipsum
                                                                    dolor sit amet consectetur adipisicing elit</p>
                                                            </div>
                                                            <div>
                                                                <el-button type="primary" @click="openAddDrawer = true" size="small" icon="el-icon-user-solid">Add New Student</el-button>
                                                                <!-- <button type="button" class="btn btn-primary btn-sm" @click="openAddDrawer = true" data-bs-toggle="offcanvas" data-bs-target="#addClient" aria-controls="addClient">
                                                                    <i class="fas fa-user-plus pe-2"></i>
                                                                    Add new Student
                                                                </button> -->
                                                            </div>
                                                        </div>
                                                        <el-table v-if="this.tableData" style="width: 100%" border height="400" v-loading="tableLoad" element-loading-text="Loading. Please wait..." element-loading-spinner="el-icon-loading">
                                                            <el-table-column label="No." type="index" width="50">
                                                            </el-table-column>
                                                            <el-table-column sortable label="Name" width="200" prop="name">
                                                            </el-table-column>
                                                            <el-table-column sortable label="Last name" width="200" prop="last_name">
                                                            </el-table-column>
                                                            <el-table-column sortable label="Birthdate" width="200" prop="birthdate">
                                                            </el-table-column>
                                                            <el-table-column sortable label="Gender" prop="gender" width="110" column-key="gender">
                                                                <!--  -->
                                                            </el-table-column>
                                                        </el-table>
                                                        <!-- <div class="table-responsive mt-1">
                                                            <table class="table table-hover select-table" v-if="this.tableData" style="width: 100%" border height="400" v-loading="tableLoad" element-loading-text="Loading. Please wait..." element-loading-spinner="el-icon-loading">
                                                                <thead class="thead">
                                                                    <tr>
                                                                        <th>
                                                                            <div class="form-check form-check-flat mt-0">
                                                                                <label class="form-check-label">
                                                                                    <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                                                            </div>
                                                                        </th>
                                                                        <th>Student</th>
                                                                        <th>Year</th>
                                                                        <th>Course</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check form-check-flat mt-0">
                                                                                <label class="form-check-label">
                                                                                    <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex ">
                                                                                <img src="" :src="tableData.avatar" alt="">
                                                                                <div>
                                                                                    <h6 prop="name" v-for="tableData.name"></h6>
                                                                                    <p>Student</p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <h6>Year</h6>
                                                                            <p>section</p>
                                                                        </td>
                                                                        <td>
                                                                            <h6>Course</h6>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge badge-opacity-warning">In
                                                                                progress</span>
                                                                        </td>
                                                                        <td>
                                                                            <div class="">
                                                                                <button type="button" class="btn-sm btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="fas fa-eye"></i></button>
                                                                                <button type="button" class="btn-sm btn-warning me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit text-light"></i></button>
                                                                                <button type="button" class="btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Add Drawer -->
    <el-drawer title="New Admission" :visible.sync="openAddDrawer" size="90%" :before-close="closeAddDrawer">
        <div class="container-fluid p-4 d-flex flex-column pe-5">
            <div id="registrationStep" class="step" v-if="active == 0">
                <form @submit.prevent="submitForm" class="" method="post" action="{{route('admin-admission')}}">
                    @csrf
                    <div class="row justify-content-start align-items-center g-2 mb-4">
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': identificationError }">
                                <span class="input-group-text group-text">Identification No.</span>
                                <input type="text" class="form-control" id="identification" name="identification" v-model="identification" onKeyup="addDashes(identification)">
                            </div>
                            <div v-text="identificationError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': yearError }">
                                <span class="input-group-text group-text">Year<span class="text-muted card-subtitle ps-2"></span></span>
                                <select class="form-select" id="year" name="year" v-model="year">
                                    <option value="" selected>Select Year</option>
                                    <option value="First Year">First Year</option>
                                    <option value="Second Year">Second Year</option>
                                    <option value="Third Year">Third Year</option>
                                    <option value="Fourth Year">Fourth Year</option>
                                </select>
                            </div>
                            <div v-text="yearError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4">
                                <span class="input-group-text group-text">Course</span>
                                <input type="text" class="form-control" id="course" name="course" v-model="course" value="Nursing" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2 mb-4">
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': firstnameError }">
                                <span class="input-group-text group-text">First Name</span>
                                <input type="text" class="form-control" id="firstname" name="firstname" v-model="firstname" onKeyup="upperCase(firstname)">
                            </div>
                            <div v-text="firstnameError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': midnameError }">
                                <span class="input-group-text group-text">Middle Name <span class="text-muted card-subtitle ps-2"></span></span>
                                <input type="text" class="form-control" id="midname" name="midname" v-model="midname" onKeyup="upperCase(midname)">
                            </div>
                            <div v-text="midnameError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': lastnameError }">
                                <span class="input-group-text group-text">Last Name</span>
                                <input type="text" class="form-control" id="lastname" name="lastname" v-model="lastname" onKeyup="upperCase(lastname)">
                            </div>
                            <div v-text="lastnameError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': phoneError }">
                                <span class="input-group-text group-text">Phone Number</span>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" v-model="phone_number" placeholder="+639*******">
                            </div>
                            <div v-text="phoneError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': genderError }">
                                <span class="input-group-text group-text me-4">Gender</span>
                                <input type="radio" class="btn-check" name="gender" id="male" value="Male" v-model="gender">
                                <label class="btn btn-outline-primary px-4 mx-2" for="male">Male</label>
                                <input type="radio" class="btn-check" name="gender" id="female" value="Female" v-model="gender">
                                <label class="btn btn-outline-danger px-4 mx-2" for="female">Female</label>
                            </div>
                            <div v-text="genderError" class="text-danger fst-italic ms-5"></div>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2 mb-4">
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': birthdateError }">
                                <span class="input-group-text group-text" for="birthdaypicker">Date of Birth</span>
                                <input type="date" name="birthdate" class="form-control" :max="maxDate" id="birthdaypicker" v-model="birthdate">
                            </div>
                            <div v-text="birthdateError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': civilError }">
                                <span class="input-group-text group-text">Civil Status<span class="text-muted card-subtitle ps-2"></span></span>
                                <select class="form-select" id="civil" name="civil" v-model="civil">
                                    <option value="" selected>Select Year</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                            <div v-text="civilError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': citizenError }">
                                <span class="input-group-text group-text">Citizenship</span>
                                <select class="form-select" id="citizen" name="citizen" v-model="citizen">
                                    <option value="" selected>Select Year</option>
                                    <option value="Filipino">Filipino</option>
                                    <option value="American">American</option>
                                </select>
                            </div>
                            <div v-text="citizenError" class="text-danger fst-italic ms-5"></div>
                        </div>
                    </div>
                    <h4 class="">Address</h4>
                    <div class="row justify-content-start align-items-center g-2 mb-4">
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': streetError }">
                                <span class="input-group-text group-text">Street No. and Street Address</span>
                                <input type="text" class="form-control" id="street" name="street" v-model="street" onKeyup="upperCase(street)">
                            </div>
                            <div v-text="streetError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': brgyError }">
                                <span class="input-group-text group-text">Barangay </span>
                                <input type="text" class="form-control" id="brgy" name="brgy" v-model="brgy" onKeyup="upperCase(brgy)">
                            </div>
                            <div v-text="brgyError" class="text-danger fst-italic ms-5"></div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group mb-4" :class="{ 'has-error': cityError }">
                                <span class="input-group-text group-text">Municipality/City</span>
                                <input type="text" class="form-control" id="city" name="city" v-model="city" onKeyup="upperCase(city)">
                            </div>
                            <div v-text="cityError" class="text-danger fst-italic ms-5"></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 0">
                        <button class="btn btn-outline-primary btn-sm" type="submit">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
                    </div>
                </form>
                <div class="progress mt-4" :space="800" :active="active" finish-status="success">
                    <div class="progress-bar" v-if="active == 0" title="Step 1" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">Step 1</div>
                </div>
            </div>
        </div>
    </el-drawer>
    <!-- active == 1 -->
    <el-drawer title="New Admission" v-if="active == 1" :visible.sync="openAddDrawer" size="90%" :before-close="closeAddDrawer">
        <div id="categoryStep" class="step container-fluid mt-2">
            <div class="row justify-content-center align-items-center g-2 mb-4">
                <div class="col-lg-4 col-md-12">
                    <div>
                        <a href="javascript:void(0)" @click="cbc">
                            <div class="card card-overflow-hidden cbc-checkup" :class="{'card-border-cbc': this.isCBC}">
                                <img class="w-25 mx-auto" src="<?php echo asset('storage/assets/img/cbc.png') ?>" alt="Complete Blood Count">
                                <div :class="this.isCBC ? 'card-with-hover-active' : 'card-with-hover'">
                                    <div class="card-text-center">
                                        <h4 class="text-center">Complete Blood Count</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div>
                        <a href="javascript:void(0)" @click="urinalysis">
                            <div class="card card-overflow-hidden urinalysis-checkup" :class="{'card-border-urinalysis': this.isUrinalysis}">
                                <img class="w-25 mx-auto" src="<?php echo asset('storage/assets/img/urinalysis.png') ?>" alt="Urinalysis">
                                <div :class="this.isUrinalysis ? 'card-with-hover-active' : 'card-with-hover'">
                                    <div class="card-text-center">
                                        <h4 class="text-center">Urinalysis</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div>
                        <a href="javascript:void(0)" @click="fecalysis">
                            <div class="card card-overflow-hidden fecalysis-checkup" :class="{'card-border-fecalysis': this.isFecalysis}">
                                <img class="w-25 mx-auto" src="<?php echo asset('storage/assets/img/fecalysis.png') ?>" alt="Fecalysis">
                                <div :class="this.isFecalysis ? 'card-with-hover-active' : 'card-with-hover'">
                                    <div class="card-text-center">
                                        <h4 class="text-center">Fecalysis</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center g-2">
                <div class="col-lg-4 col-md-12">
                    <div>
                        <a href="javascript:void(0)" @click="xray">
                            <div class="card card-overflow-hidden xray-checkup" :class="{'card-border-xray': this.isXray}">
                                <img class="w-25 mx-auto" src="<?php echo asset('storage/assets/img/x-ray.png') ?>" alt="Chest X-ray">
                                <div :class="this.isXray ? 'card-with-hover-active' : 'card-with-hover'">
                                    <div class="card-text-center">
                                        <h4 class="text-center">Chest X-ray (PA)</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div>
                        <a href="javascript:void(0)" @click="antigen">
                            <div class="card card-overflow-hidden antigen-checkup" :class="{'card-border-antigen': this.isAntigen}">
                                <img class="w-25 mx-auto" src="<?php echo asset('storage/assets/img/hepa-antigen.png') ?>" alt="Heppa B Antigen">
                                <div :class="this.isAntigen ? 'card-with-hover-active' : 'card-with-hover'">
                                    <div class="card-text-center">
                                        <h4 class="text-center">Heppa B Antigen</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div>
                        <a href="javascript:void(0)" @click="vaccine">
                            <div class="card card-overflow-hidden vaccine-checkup" :class="{'card-border-vaccine': this.isVaccine}">
                                <img class="w-25 mx-auto" src="<?php echo asset('storage/assets/img/hepa-vaccine.png') ?>" alt="Heppa B Vaccine">
                                <div :class="this.isVaccine ? 'card-with-hover-active' : 'card-with-hover'">
                                    <div class="card-text-center">
                                        <h4 class="text-center">Heppa B Vaccine</h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 1">
                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                <button class="btn btn-outline-primary btn-sm" @click="next">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
            </div>
            <div class="progress mt-4" :space="800" :active="active" finish-status="success">
                <div class="progress-bar bg-warning" v-if="active == 1" title="Step 2" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Step 2</div>
            </div>
        </div>
    </el-drawer>
    @endsection
</body>

</html>