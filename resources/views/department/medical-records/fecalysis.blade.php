@extends('department/medical-records/layout/fecalysis-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Fecalysis Record')
</head>

<body>
    <div id="app" v-loading.fullscreen.lock="fullscreenLoading">
    @include('department/imports/nav')
        <div class="container mt-3">
            <div class="row justify-content-center align-items-center g-2">
                <div class="col ms-auto"><h3>Fecalysis List</h3></div>
                <div class="col-lg-5 me-auto">
                    <div class="d-flex">
                        <el-select v-model="searchValue" placeholder="Select Column" @changed="changeColumn" clearable>
                            <el-option v-for="search in options" :key="search.value" :label="search.label" :value="search.value">
                            </el-option>
                        </el-select>
                        <div class="ps-2">
                            <div v-if="searchValue == 'identification'">
                                <el-input prefix-icon="el-icon-search" v-model="searchID" placeholder="Type to search..." clearable />
                            </div>
                            <div v-else-if="searchValue == 'name'">
                                <el-input prefix-icon="el-icon-search" v-model="searchName" placeholder="Type to search..." clearable />
                            </div>
                            <div v-else>
                                <el-input prefix-icon="el-icon-search" v-model="searchNull" placeholder="Type to search..." clearable />
                            </div>
                        </div>
                        <div class="ms-2">
                            <el-dropdown size="small">
                                <el-button type="primary">
                                    Medical Records<i class="el-icon-arrow-down el-icon--right"></i>
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <a class="dropdown-item" href="{{route('cbcFile')}}"><i class="fas fa-file-medical pe-2 text-muted"></i>Complete Blood Count</a>
                                    <a class="dropdown-item" href="{{route('antigenFile')}}"><i class="fas fa-file-medical pe-2 text-muted"></i>Heppa B Antigen</a>
                                    <a class="dropdown-item" href="{{route('vaccineFile')}}"><i class="fas fa-file-medical pe-2 text-muted"></i>Heppa B Vaccine</a>
                                    <a class="dropdown-item" href="{{route('urinalysisFile')}}"><i class="fas fa-file-medical pe-2 text-muted"></i>Urinalysis</a>
                                    <a class="dropdown-item" href="{{route('fecalysisFile')}}"><i class="fas fa-file-medical pe-2 text-muted"></i>Fecalysis</a>
                                    <a class="dropdown-item" href="{{route('xrayFile')}}"><i class="fas fa-file-medical pe-2 text-muted"></i>Chest X-ray</a>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="my-3">
                <el-table v-if="this.tableData" :data="usersTable" style="width: 100%" border height="400" v-loading="tableLoad" element-loading-text="Loading. Please wait..." element-loading-spinner="el-icon-loading">
                    <el-table-column label="No." type="index" width="50">
                    </el-table-column>
                    <el-table-column sortable label="Identification No." width="200" prop="identification">
                    </el-table-column>
                    <el-table-column sortable label="Full Name" prop="name">
                    </el-table-column>
                    <el-table-column sortable label="Birthdate" prop="birthdate">
                    </el-table-column>
                    <el-table-column sortable label="Gender" prop="gender">
                        <template slot-scope="scope">
                            <el-tag size="small" v-if="scope.row.gender == 'Male'"><span v-text="scope.row.gender"></span></el-tag>
                            <el-tag size="small" v-else type="danger"><span v-text="scope.row.gender"></span></el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="Status" prop="status" column-key="status">
                        <template slot-scope="scope">
                            <el-tag size="small" type="success" v-if="scope.row.status=='Active'"><span v-text="scope.row.status"></span></el-tag>
                            <el-tag size="small" type="info" v-else><span v-text="scope.row.status"></span></el-tag>
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
        </div>
        <!----------------------------------------------------------------------------------- Modals/Drawers ----------------------------------------------------------------------------------->
        <!-- View Dialog -->
        <el-dialog :visible.sync="viewDialog" width="35%" :before-close="closeViewDialog">
            <template #title>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fs-5">User<span class="mx-2" v-text="viewStudent.firstname"></span></div>
                </div>
            </template>
            <div class="container">
                <div class="">
                    <div class="card-body content">
                        <h3 class="card-title">Fecalysis</h3>
                        <div class="container">
                            <div class="row align-items-center g-2 my-2">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" v-model="viewStudent.name" disabled />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Age</label>
                                        <input type="text" class="form-control" v-model="viewStudent.age" disabled />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Gender</label>
                                        <input type="text" class="form-control" v-model="viewStudent.gender" disabled />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" v-model="viewStudent.address" disabled />
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center g-2 my-2">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Requested By:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.requestBy" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Date of request:</label>
                                        <input type="date" class="form-control" v-model="viewStudent.requestDate" disabled />
                                    </div>
                                </div>
                                <h5 class="text-success">PHYSICAL PROPERTIES</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Color:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.color" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Consistency:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.consistency" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <h5 class="text-success">CHEMICAL PROPERTIES</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Occult Blood:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.occult"disabled />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Others:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.otherOccult" disabled/>
                                    </div>
                                </div>
                                <h5 class="text-success">MICROSCOPIC FINDINGS</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Pus cells:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.pus" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">RBC:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.rbc" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Fat GLobules:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.fat" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <h5 class="text-success">HELMINTHS</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Ova:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.ova" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Larva:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.larva" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Adult Forms:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.adult" disabled/>
                                    </div>
                                </div>
                                <h5 class="text-success">PROTOZOA</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Cyst:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.cyst" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Trophozoites:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.trophozoites" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Others:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.otherTrophozoites" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <h5 class="text-dark">REMARKS</h5>
                                <textarea type="text" class="form-control" v-model="viewStudent.remarks"disabled></textarea>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Pathologist:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.pathologist" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Medical Technologist:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.technologist" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="closeViewDialog">Close</el-button>
            </span>
        </el-dialog>
    </div>
@include('department/imports/body')
</body>
</html>