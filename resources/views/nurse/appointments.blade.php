@extends('nurse/layout/appointments-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Appointments')
</head>

<body>
    @section('sidebar')
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
            <div class="container-fluid border rounded p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0">Student Appointments Table</p>
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
                            <div v-else-if="searchValue == 'med_status'">
                                <el-input v-model="searchStatus" size="mini" placeholder="Type to search..." clearable />
                            </div>
                            <div v-else-if="searchValue == 'yearandsection'">
                                <el-input v-model="searchYrandSect" size="mini" placeholder="Type to search..." clearable />
                            </div>
                            <div v-else>
                                <el-input v-model="searchNull" size="mini" placeholder="Type to search..." clearable />
                            </div>
                        </div>
                    </div>
                </div>
                <el-table v-if="this.tableData" :data="usersTable" style="width: 120%" border height="600" v-loading="tableLoad" element-loading-text="Loading. Please wait..." element-loading-spinner="el-icon-loading">
                    <el-table-column label="No." type="index" width="50">
                    </el-table-column>
                    <el-table-column sortable label="Identification No." width="200" prop="identification">
                    </el-table-column>
                    <el-table-column sortable label="Date Requested" width="220" prop="created_at">
                    </el-table-column>
                    <el-table-column sortable label="Full Name" width="220" prop="name">
                    </el-table-column>
                    <el-table-column sortable label="Year and Section" width="250" prop="yearandsection">
                        <template slot-scope="scope">
                            <el-tag size="small" v-if="scope.row.year == 'Fourth Year'"><span v-text="scope.row.yearandsection"></span></el-tag>
                            <el-tag size="small" type="warning" v-if="scope.row.year == 'First Year'"><span v-text="scope.row.yearandsection"></span></el-tag>
                            <el-tag size="small" type="success" v-if="scope.row.year == 'Second Year'"><span v-text="scope.row.yearandsection"></span></el-tag>
                            <el-tag size="small" v-if="scope.row.year == 'Third Year'" type="danger"><span v-text="scope.row.yearandsection"></span></el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column sortable label="Status" width="120" prop="med_status">
                        <template slot-scope="scope">
                            <el-tag size="small" type="success" v-if="scope.row.med_status == 'Approved'"><span v-text="scope.row.med_status"></span></el-tag>
                            <el-tag size="small" type="primary" v-if="scope.row.med_status == 'Done'"><span v-text="scope.row.med_status"></span></el-tag>
                            <el-tag size="small" type="warning" v-if="scope.row.med_status == 'Pending'"><span v-text="scope.row.med_status"></span></el-tag>
                            <el-tag size="small" type="danger" v-if="scope.row.med_status == 'Declined'"><span v-text="scope.row.med_status"></span></el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column sortable label="Requested Schedule"prop="request_date">
                    </el-table-column>
                    <el-table-column sortable label="Actions" column-key="med_status">
                        <template slot-scope="scope">
                            <div class="row justify-content-center align-items-center g-2" v-if="scope.row.med_status == 'Pending'">
                                <div class="col-auto">
                                    <el-tooltip class="item" effect="dark" :content="scope.row.med_status == 'Approved' ? 'Declined' : 'Approve'" placement="top-start">
                                        <el-button icon="el-icon-check" size="small" type="success" v-model="scope.row.med_status" @click="handleApproved(scope.$index, scope.row)" active-value="Approved" inactive-value="Declined" active-color="#13ce66" :active-text="scope.row.med_status == 'Approved' ? 'Approved' : 'Declined'" :disabled="scope.row.med_status == 'Approved'"></el-button>
                                    </el-tooltip>
                                </div>
                                <div class="col-auto">
                                    <el-tooltip class="item" effect="dark" :content="scope.row.med_status == 'Declined' ? 'Approved' : 'Decline'" placement="top-start">
                                        <el-button icon="el-icon-close" size="small" type="danger" v-model="scope.row.med_status" @click="handleRejected(scope.$index, scope.row)" active-value="Declined" inactive-value="Approved" active-color="#13ce66" :active-text="scope.row.med_status == 'Declined' ? 'Declined' : 'Approved'" :disabled="scope.row.med_status == 'Declined'"></el-button>
                                    </el-tooltip>
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center g-2" v-if="scope.row.med_status == 'Approved'">
                                <div class="col-auto">
                                    <el-tooltip class="item" effect="dark" content="Done" placement="top-start">
                                        <el-button icon="el-icon-check" size="small" type="primary" v-model="scope.row.med_status" @click="handleDone(scope.$index, scope.row)" :disabled="scope.row.med_status == 'Done'">Done</el-button>
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
    </main>
    @endsection
</body>

</html>