@extends('nurse/medical-records/layout/urinalysis-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('nurse/imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'CBC Records')
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
    <!-- sidebar -->
    <div class="container-fluid page-wrapper">
    @include('nurse/imports/sidebar')
    <main class="main-panel flex-lg-grow-1">
        <el-main>
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
            <div class="container border rounded p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0">Urinalysis Information Table</p>
                    <div class="d-flex">
                        <el-select v-model="searchValue" size="mini" placeholder="Select Column" @changed="changeColumn" clearable>
                            <el-option v-for="search in options" :key="search.value" :label="search.label" :value="search.value">
                            </el-option>
                        </el-select>
                        <div class="ps-2">
                            <div v-if="searchValue == 'identification'">
                                <el-input v-model="searchID" size="mini" placeholder="Type to search..." clearable />
                            </div>
                            <div v-else-if="searchValue == 'name'">
                                <el-input v-model="searchName" size="mini" placeholder="Type to search..." clearable />
                            </div>
                            <div v-else>
                                <el-input v-model="searchNull" size="mini" placeholder="Type to search..." clearable />
                            </div>
                        </div>
                    </div>
                </div>
                <el-table v-if="this.tableData" :data="usersTable" style="width: 100%" border height="600" v-loading="tableLoad" element-loading-text="Loading. Please wait..." element-loading-spinner="el-icon-loading">
                    <el-table-column label="No." type="index" width="50">
                    </el-table-column>
                    <el-table-column sortable label="Identification No." width="200" prop="identification">
                    </el-table-column>
                    <el-table-column sortable label="Full Name" width="220" prop="name">
                    </el-table-column>
                    <el-table-column sortable label="Birthdate" width="200" prop="birthdate">
                    </el-table-column>
                    <el-table-column sortable label="Gender" width="150" prop="gender">
                        <template slot-scope="scope">
                            <el-tag size="small" v-if="scope.row.gender == 'Male'"><span v-text="scope.row.gender"></span></el-tag>
                            <el-tag size="small" v-else type="danger"><span v-text="scope.row.gender"></span></el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="Status" prop="status" width="150" column-key="status">
                        <template slot-scope="scope">
                            <el-tooltip class="item" effect="dark" :content="scope.row.status == 'Active' ? 'Deactivate' : 'Activate'" placement="top-start">
                                <el-switch v-model="scope.row.status" @change="handleSwitch(scope.row)" active-value="Active" inactive-value="Inactive" active-color="#13ce66" :active-text="scope.row.status == 'Active' ? 'Active' : 'Inactive'" :disabled="scope.row.status == 'Inactive'">
                                </el-switch>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                    <el-table-column label="Actions">
                        <template slot-scope="scope">
                            <div class="row justify-content-center align-items-center g-2">
                                <div class="col">
                                    <el-tooltip class="item" effect="dark" content="View" placement="top-start">
                                        <el-button icon="el-icon-view" size="mini" type="warning" @click="handleView(scope.$index, scope.row)"></el-button>
                                    </el-tooltip>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
                <div class="d-flex justify-content-between mt-2">
                    <el-checkbox v-model="showAllData">Show All</el-checkbox>
                    <el-pagination :current-page.sync="page" :pager-count="5" :page-size="this.pageSize" background layout="prev, pager, next" :total="this.tableData.length" @current-change="setPage">
                    </el-pagination>
                </div>
            </div>
        </el-main>
        <!----------------------------------------------------------------------------------- Modals/Drawers ----------------------------------------------------------------------------------->
        <!-- View Dialog -->
        <el-dialog v-for="urine in isUrinalysis" :visible.sync="viewDialog" width="50%" :before-close="closeViewDialog">
            <template #title>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fs-5">User<span class="mx-2" v-text="viewStudent.firstname"></span></div>
                    <div class="pe-4">
                        <el-avatar :size="70" :src="viewStudent.avatar"></el-avatar>
                    </div>
                </div>
            </template>
            <div class="container">
                <div class="row justify-content-center align-items-center g-2 mb-3">
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Identification No.</label>
                        <el-input v-model="viewStudent.identification" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Year Level</label>
                        <el-input v-model="viewStudent.year" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Section</label>
                        <el-input v-model="viewStudent.classSection" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Course</label>
                        <el-input v-model="viewStudent.course" disabled></el-input>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center g-2 mb-3">
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Name</label>
                        <el-input v-model="viewStudent.name" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Gender</label>
                        <el-input v-model="viewStudent.gender" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Birthdate</label>
                        <el-input v-model="viewStudent.birthdate" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Age</label>
                        <el-input v-model="viewStudent.age" disabled></el-input>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center g-2 mb-3">
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Address</label>
                        <el-input v-model="viewStudent.address" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Citizenship</label>
                        <el-input v-model="viewStudent.citizen" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Civil Status</label>
                        <el-input v-model="viewStudent.civil" disabled></el-input>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <label class="form-label">Phone No.</label>
                        <el-input v-model="viewStudent.phone_number" disabled></el-input>
                    </div>
                </div>
                <div class="row justify-content-center align-items-center g-2 mb-3">
                    <div class="col-lg-6 col-md-12">
                        <label class="form-label">Contact Person</label>
                        <el-input v-model="viewStudent.guardian" disabled></el-input>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <label class="form-label">Contact Person Phone No.</label>
                        <el-input v-model="viewStudent.guardianPhone_number" disabled></el-input>
                    </div>
                </div>
                <hr>
                <div class="card">                
                    <div class="card-body">
                        <img :src="urine.result" class="img-fluid rounded-top w-100" alt="Antigen Result">
                    </div>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="closeViewDialog">Close</el-button>
            </span>
        </el-dialog>
    </main>
    </div>
</div>
</body>
@include('nurse/imports/body')

</html>