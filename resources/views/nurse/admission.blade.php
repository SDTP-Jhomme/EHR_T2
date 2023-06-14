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
        <el-header class="mt-4" height="40">
            <div class="container p-0">
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-button type="primary" @click="openAddDrawer = true" size="small" icon="el-icon-user-solid">Add New Admission</el-button>
                    </el-col>
                </el-row>
            </div>
        </el-header>

        <el-main>
            <div class="container border rounded p-4">
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
                                <div class="col">
                                    <el-tooltip class="item" effect="dark" content="Edit" placement="top-start">
                                        <el-button icon="el-icon-edit" size="mini" type="primary" @click="handleEdit(scope.$index, scope.row)"></el-button>
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
        
        <!-- Add Dialog -->
        <el-drawer title="New Admission" :visible.sync="openAddDrawer" size="90%" :before-close="closeAddDrawer">
            <div class="container-fluid p-4 d-flex flex-column pe-5">
                <div id="registrationStep" class="step" v-if="active == 0">
                <form @submit.prevent="submitForm" class="" method="post" action="#">
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
                                    <span class="input-group-text group-text">Section</span>
                                    <select class="form-select" id="classSection" name="classSection" v-model="classSection">
                                        <option value="" selected>Select Section</option>
                                        <option value="A Section">A</option>
                                        <option value="B Section">B</option>
                                        <option value="C Section">C</option>
                                    </select>
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
        <!-- Add Dialog End -->

        <!-- Active 1 -->
        <el-drawer title="New Admission" v-if="active == 1" :visible.sync="openAddDrawer" size="90%" :before-close="closeAddDrawer">
        <div id="categoryStep" class="step container-fluid mt-2">
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
            <div class="d-flex justify-content-center align-items-center mt-2" v-if="active == 1">
                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                <button class="btn btn-outline-primary btn-sm" @click="next">Next <i class="fas fa-arrow-circle-right ps-2"></i></button>
            </div>
            <div class="progress mt-4" :space="800" :active="active" finish-status="success">
                <div class="progress-bar bg-warning" v-if="active == 1" title="Step 2" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Step 2</div>
            </div>
        </div>
    </el-drawer>
        <!-- Active 1 End -->

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
                    </el-descriptions>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="closeViewDialog">Close</el-button>
            </span>
        </el-dialog>
        <!-- Edit Dialog -->
        <el-dialog :visible.sync="editDialog" width="50%" :before-close="closeEditDialog">
            <template #title>
                Edit User <span class="mx-2" v-text="editStudent.firstname"></span>
            </template>
            <el-form :label-position="leftLabel" label-width="160px" :model="updateStudent" :rules="editRules" ref="updateStudent">
                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
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
                    <div class="col">
                        <el-form-item label="Phone No." prop="phone_number">
                            <el-input v-model="updateStudent.phone_number" clearable></el-input>
                        </el-form-item>
                    </div>
                    <div class="col">
                        <el-form-item label="Birthday" prop="birthdate">
                            <el-date-picker :picker-options="birthdayOptions" v-model="updateStudent.birthdate" type="date" placeholder="Select birthdate" clearable>
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
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button :loading="loadButton" @click="closeEditDialog('updateStudent')">Cancel</el-button>
                <el-button :loading="loadButton" type="primary" @click="updateUser('updateStudent')">Update</el-button>
            </span>
        </el-dialog>
    </main>
    @endsection
</body>

</html>