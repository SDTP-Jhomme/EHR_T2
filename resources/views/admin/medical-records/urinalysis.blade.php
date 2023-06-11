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
                    <div class="pe-4">
                        <el-avatar :size="70" :src="viewStudent.avatar"></el-avatar>
                    </div>
                </div>
            </template>
            <div class="container">
                <div class="">
                    <el-descriptions direction="horizontal" :column="1" border>
                        <el-descriptions-item label="Identification Number"><span class="mx-2" v-text="viewStudent.identification"></el-descriptions-item>
                        <el-descriptions-item label="Name"><span class="mx-2" v-text="viewStudent.name"></el-descriptions-item>
                        <el-descriptions-item label="Birthday"><span class="mx-2" v-text="viewStudent.birthdate"></el-descriptions-item>
                        <el-descriptions-item label="Gender">
                            <el-tag v-if="viewStudent.gender == 'Male'"><span class="mx-2" v-text="viewStudent.gender"></el-tag>
                            <el-tag v-else type="danger"><span class="mx-2" v-text="viewStudent.gender"></el-tag>
                        </el-descriptions-item>
                        <el-descriptions-item label="Date of request"><span class="mx-2" v-text="viewStudent.requestDate"></el-descriptions-item>
                        <h5 class="text-success">PHYSICAL PROPERTIES</h5>
                        <el-descriptions-item label="Color"><span class="mx-2" v-text="viewStudent.color"></el-descriptions-item>
                        <el-descriptions-item label="Transparency"><span class="mx-2" v-text="viewStudent.transparency"></el-descriptions-item>
                        <el-descriptions-item label="Specific Gravity"><span class="mx-2" v-text="viewStudent.gravity"></el-descriptions-item>
                                <h5 class="text-success">CHEMICAL ANALYSIS</h5>
                        <el-descriptions-item label="Ph"><span class="mx-2" v-text="viewStudent.ph"></el-descriptions-item>
                        <el-descriptions-item label="Sugar"><span class="mx-2" v-text="viewStudent.sugar"></el-descriptions-item>
                        <el-descriptions-item label="Protein"><span class="mx-2" v-text="viewStudent.protein"></el-descriptions-item>
                        <el-descriptions-item label="Pregnancy Test"><span class="mx-2" v-text="viewStudent.pregnancy"></el-descriptions-item>
                                <h5 class="text-success">MICROSCOPIC EXAMINATION</h5>
                        <el-descriptions-item label="Pus cells"><span class="mx-2" v-text="viewStudent.pus"></el-descriptions-item>
                        <el-descriptions-item label="RBC"><span class="mx-2" v-text="viewStudent.rbc"></el-descriptions-item>
                        <el-descriptions-item label="Cast"><span class="mx-2" v-text="viewStudent.cast"></el-descriptions-item>
                                <h5 class="text-success">CRYSTAL</h5>
                        <el-descriptions-item label="Urates"><span class="mx-2" v-text="viewStudent.urates"></el-descriptions-item>
                        <el-descriptions-item label="Uric Acid"><span class="mx-2" v-text="viewStudent.uric"></el-descriptions-item>
                        <el-descriptions-item label="Cal Ox"><span class="mx-2" v-text="viewStudent.cal"></el-descriptions-item>
                                <h5 class="text-success">OTHERS</h5>
                        <el-descriptions-item label="Epith Cells"><span class="mx-2" v-text="viewStudent.epith"></el-descriptions-item>
                        <el-descriptions-item label="Mucus Threads"><span class="mx-2" v-text="viewStudent.mucus"></el-descriptions-item>
                        <el-descriptions-item label="Others"><span class="mx-2" v-text="viewStudent.otherOthers"></el-descriptions-item>
                        <el-descriptions-item label="Pathologist"><span class="mx-2" v-text="viewStudent.pathologist"></el-descriptions-item>
                        <el-descriptions-item label="Medical Technologist"><span class="mx-2" v-text="viewStudent.technologist"></el-descriptions-item>
                    </el-descriptions>
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
@include('admin/imports/body')

</html>