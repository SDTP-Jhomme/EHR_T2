@extends('nurse/layout/admission-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Admission')
</head>

<body>
    @section('sidebar')
    <main class="main-panel flex-lg-grow-1">
        <el-main class=" mb-4">
            <div class="container border rounded p-4 mb-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0">Student Information Table</p>
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
                        <el-button class="ms-2" type="primary" size="mini" @click="printTable">Print Table</el-button>
                    </div>
                </div>
                <el-table v-if="this.tableData" :data="usersTable" style="width: 100%" border height="500" v-loading="tableLoad" element-loading-text="Loading. Please wait..." element-loading-spinner="el-icon-loading">
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
                                <div class="col-auto">
                                    <el-tooltip class="item" effect="dark" content="View" placement="top-start">
                                        <el-button icon="el-icon-view" size="mini" type="warning" @click="handleView(scope.$index, scope.row)"></el-button>
                                    </el-tooltip>
                                </div>
                                <div class="col-auto">
                                    <el-tooltip class="item" effect="dark" content="Edit" placement="top-start">
                                        <el-button icon="el-icon-edit" size="mini" type="primary" @click="handleEdit(scope.$index, scope.row)"></el-button>
                                    </el-tooltip>
                                </div>
                                <div class="col-auto">
                                    <el-tooltip class="item" effect="dark" content="Add Result" placement="top-start">
                                        <el-button type="primary" size="mini" @click="handleResult(scope.$index, scope.row)" size="small" icon="el-icon-picture"></el-button>
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
                <div class="container" id="myTable" >
                </div>
            </div>
        </el-main>
        <!----------------------------------------------------------------------------------- Modals/Drawers ----------------------------------------------------------------------------------->
        <!-- Add Result Dialog -->
        <el-dialog title="Add Results" :visible.sync="resultDialog" :before-close="closeResultDialog">
            <div class="card">
                <div class="card-body">
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
                    <div id="categoryStep" v-if="active == 0" class="step container-fluid mt-2">
                        <div class="row justify-content-center align-items-center g-2 mb-4">
                            <div class="col-lg-4 col-md-12">
                                <div>
                                    <a href="javascript:void(0)" @click="cbc">
                                        <div class="card card-overflow-hidden cbc-checkup" :class="{'card-border-cbc': this.isCBC}">
                                            <img class="w-25 mx-auto" src="<?php echo asset('assets/img/cbc.png') ?>" alt="Complete Blood Count">
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
                                            <img class="w-25 mx-auto" src="<?php echo asset('assets/img/urinalysis.png') ?>" alt="Urinalysis">
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
                                            <img class="w-25 mx-auto" src="<?php echo asset('assets/img/fecalysis.png') ?>" alt="Fecalysis">
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
                                            <img class="w-25 mx-auto" src="<?php echo asset('assets/img/x-ray.png') ?>" alt="Chest X-ray">
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
                                            <img class="w-25 mx-auto" src="<?php echo asset('assets/img/hepa-antigen.png') ?>" alt="Heppa B Antigen">
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
                                            <img class="w-25 mx-auto" src="<?php echo asset('assets/img/hepa-vaccine.png') ?>" alt="Heppa B Vaccine">
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
                        <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 0">
                            <button class="btn btn-outline-primary btn-sm me-2" @click="closeResultDialog"><i class="fas fa-arrow-circle-left pe-2"></i>Cancel</button>
                            <button class="btn btn-outline-primary btn-sm" @click="next">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
                        </div>
                        <div class="progress mt-4" :space="800" :active="active" finish-status="success">
                            <div class="progress-bar bg-primary" v-if="active == 0" title="50%" role="progressbar" style="width: 50%;" aria-valuemin="0" aria-valuemax="100">50%</div>
                        </div>
                    </div>
                    <div id="categoryStep" v-if="active == 1" class="step container-fluid mt-2">
                        <div v-if="this.isCBC" class="container-fluid">
                            <div class="d-flex justify-content-center">
                                <input type="file" ref="file" class="form-control" @change="fileUpload" />
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 1">
                                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                                <button :loading="loadButton" class="btn btn-outline-primary btn-sm" @click="submitCbc">Submit <i class="fas fa-arrow-circle-right ps-2"></i></button>
                            </div>
                        </div>
                        <div v-if="this.isUrinalysis" class="container-fluid">
                            <div class="d-flex justify-content-center">
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 1">
                                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                                <button class="btn btn-outline-primary btn-sm" @click="next">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
                            </div>
                        </div>
                        <div v-if="this.isFecalysis" class="container-fluid">
                            <div class="d-flex justify-content-center">
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 1">
                                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                                <button class="btn btn-outline-primary btn-sm" @click="next">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
                            </div>
                        </div>
                        <div v-if="this.isXray" class="container-fluid">
                            <div class="d-flex justify-content-center">
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 1">
                                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                                <button class="btn btn-outline-primary btn-sm" @click="next">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
                            </div>
                        </div>
                        <div v-if="this.isAntigen" class="container-fluid">
                            <div class="d-flex justify-content-center">
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 1">
                                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                                <button class="btn btn-outline-primary btn-sm" @click="next">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
                            </div>
                        </div>
                        <div v-if="this.isVaccine" class="container-fluid">
                            <div class="d-flex justify-content-center">
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 1">
                                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                                <button class="btn btn-outline-primary btn-sm" @click="next">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
                            </div>
                        </div>
                        <div class="progress mt-4" :space="800" :active="active" finish-status="success">
                            <div class="progress-bar bg-success" v-if="active == 1" title="100%" role="progressbar" style="width: 100%;" aria-valuemin="0" aria-valuemax="100">100%</div>
                        </div>
                    </div>
                </div>
            </div>
        </el-dialog>
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
                        <el-descriptions-item label="Year and Section"><span class="mx-2" v-text="viewStudent.yearandsection"></el-descriptions-item>
                        <el-descriptions-item label="Gender">
                            <el-tag v-if="viewStudent.gender == 'Male'"><span class="mx-2" v-text="viewStudent.gender"></el-tag>
                            <el-tag v-else type="danger"><span class="mx-2" v-text="viewStudent.gender"></el-tag>
                        </el-descriptions-item>
                    </el-descriptions>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="closeViewDialog">Close</el-button>
            </span>
        </el-dialog>
        <!-- Edit Dialog -->
        <el-drawer title="Edit Student" :direction="direction" :visible.sync="editDialog" size="50%" :before-close="closeEditDialog">
            <div class="container m-0">
                <el-form :label-position="topLabel" :model="updateStudent" :rules="editRules" ref="updateStudent">
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col-4">
                            <el-form-item label="Identification Number" prop="identification">
                                <el-input v-model="updateStudent.identification" maxlength="7" onKeyup="addDashes(this)" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Year Level" prop="year">
                                <el-select v-model="updateStudent.year" placeholder="Select">
                                    <el-option
                                        v-for="item in year"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    >
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Section" prop="classSection">
                                <el-select v-model="updateStudent.classSection" placeholder="Select">
                                    <el-option
                                        v-for="item in classSection"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    >
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col">
                            <el-form-item label="First Name" prop="firstname">
                                <el-input v-model="updateStudent.firstname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Middle Name" prop="midname">
                                <el-input v-model="updateStudent.midname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Last Name" prop="lastname">
                                <el-input v-model="updateStudent.lastname" clearable></el-input>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col-auto">
                            <el-form-item label="Citizenship" prop="citizen">
                                <el-select v-model="updateStudent.citizen" placeholder="Select Citizenship">
                                    <el-option
                                        v-for="item in citizen"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    >
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                        <div class="col-auto">
                            <el-form-item label="Civil Status" prop="civil">
                                <el-select v-model="updateStudent.civil" placeholder="Select Civil Status">
                                    <el-option
                                        v-for="item in civil"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    >
                                    </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col">
                            <el-form-item label="Phone Number" prop="phone_number">
                                <el-input v-model="updateStudent.phone_number" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Birthday" prop="birthdate">
                                <el-date-picker v-model="updateStudent.birthdate" type="date" placeholder="Select birthdate" :picker-options="birthdayOptions"clearable>
                                </el-date-picker>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Gender" prop="gender">
                                <el-radio-group v-model="updateStudent.gender">
                                    <el-radio-button label="Female"></el-radio-button>
                                    <el-radio-button label="Male"></el-radio-button>
                                </el-radio-group>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col">
                            <el-form-item label="Contact Person First Name" prop="guardianFname">
                                <el-input v-model="updateStudent.guardianFname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Contact Person Middle Name(optional)" prop="guardianMname">
                                <el-input v-model="updateStudent.guardianMname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Contact Person Last Name" prop="guardianLname">
                                <el-input v-model="updateStudent.guardianLname" clearable></el-input>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col-4">
                            <el-form-item label="Guardian Phone Number" prop="guardianPhone_number">
                                <el-input v-model="updateStudent.guardianPhone_number" clearable></el-input>
                            </el-form-item>
                        </div>
                    </div>
                </el-form>
            </div>
            <div class="d-flex p-4">
                <el-button :loading="loadButton" @click="closeEditDialog('updateStudent')">Cancel</el-button>
                <el-button :loading="loadButton" type="primary" @click="updateUser('updateStudent')">Update</el-button>
            </div>
        </el-drawer>
    </main>
    @endsection
</body>
</html>