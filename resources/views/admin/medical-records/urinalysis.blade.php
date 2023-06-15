@extends('admin/medical-records/layout/urinalysis-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin/imports/head')
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
    @include('admin/imports/nav')
    <!-- sidebar -->
    <div class="container-fluid page-wrapper">
    @include('admin/imports/sidebar')
    <main class="main-panel flex-lg-grow-1">
        <el-main>
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
        <el-dialog :visible.sync="viewDialog" width="35%" :before-close="closeViewDialog">
            <template #title>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fs-5">User<span class="mx-2" v-text="viewStudent.firstname"></span></div>
                </div>
            </template>
            <div class="container">
                <div class="card">
                    <div class="card-body content">
                        <h3 class="card-title">Urinalysis</h3>
                        <div class="container">
                            <div class="row align-items-center g-2 my-2">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Name</label>
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
                                        <label class="form-label">Transparency:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.transparency" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Specific Gravity:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.gravity" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <h5 class="text-success">CHEMICAL ANALYSIS</h5>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Ph:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.ph"disabled />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Sugar:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.sugar" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Protein:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.protein"disabled />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Pregnancy Test:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.pregnancy" disabled/>
                                    </div>
                                </div>
                                <h5 class="text-success">MICROSCOPIC EXAMINATION</h5>
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
                                        <label class="form-label">Cast:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.cast" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <h5 class="text-success">CRYSTAL</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Urates:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.urates" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Uric Acid:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.uric" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Cal Ox:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.cal" disabled/>
                                    </div>
                                </div>
                                <h5 class="text-success">OTHERS</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Epith Cells:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.epith" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Mucus Threads:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.mucus" disabled/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Others:</label>
                                        <input type="text" class="form-control" v-model="viewStudent.otherOthers" disabled/>
                                    </div>
                                </div>
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
                <el-button-group>
                    <el-button type="primary" @click="closeViewDialog">Close</el-button>
                    <el-button type="primary">Print<i class="el-icon-printer ps-2"></i></el-button>
                </el-button-group>
            </span>
        </el-dialog>
    </main>
    </div>
</div>
</body>
@include('admin/imports/body')

</html>