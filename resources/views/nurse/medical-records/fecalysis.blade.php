@extends('nurse/medical-records/layout/fecalysis-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('nurse/imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Fecalysis Records')
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
            <div class="container border rounded p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0">Fecalysis Information Table</p>
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
                        <el-descriptions-item label="Requested By"><span class="mx-2" v-text="viewStudent.requestBy"></el-descriptions-item>
                        <el-descriptions-item label="Date of request"><span class="mx-2" v-text="viewStudent.requestDate"></el-descriptions-item>
                        <h5 class="text-success">PHYSICAL PROPERTIES</h5>
                        <el-descriptions-item label="Color"><span class="mx-2" v-text="viewStudent.color"></el-descriptions-item>
                        <el-descriptions-item label="Consistency"><span class="mx-2" v-text="viewStudent.consistency"></el-descriptions-item>
                        <h5 class="text-success">CHEMICAL PROPERTIES</h5>
                        <el-descriptions-item label="Occult Blood"><span class="mx-2" v-text="viewStudent.occult"></el-descriptions-item>
                        <el-descriptions-item label="Others"><span class="mx-2" v-text="viewStudent.otherOccult"></el-descriptions-item>
                        <h5 class="text-success">MICROSCOPIC FINDINGS</h5>
                        <el-descriptions-item label="Pus cells"><span class="mx-2" v-text="viewStudent.pus"></el-descriptions-item>
                        <el-descriptions-item label="RBC"><span class="mx-2" v-text="viewStudent.rbc"></el-descriptions-item>
                        <el-descriptions-item label="Fat GLobules"><span class="mx-2" v-text="viewStudent.fat"></el-descriptions-item>
                        <h5 class="text-success">HELMINTHS</h5>
                        <el-descriptions-item label="Ova"><span class="mx-2" v-text="viewStudent.ova"></el-descriptions-item>
                        <el-descriptions-item label="Larva"><span class="mx-2" v-text="viewStudent.larva"></el-descriptions-item>
                        <el-descriptions-item label="Adult Forms"><span class="mx-2" v-text="viewStudent.adult"></el-descriptions-item>
                                <h5 class="text-success">PROTOZOA</h5>
                        <el-descriptions-item label="Cyst"><span class="mx-2" v-text="viewStudent.cyst"></el-descriptions-item>
                        <el-descriptions-item label="Trophozoites"><span class="mx-2" v-text="viewStudent.trophozoites"></el-descriptions-item>
                        <el-descriptions-item label="Others"><span class="mx-2" v-text="viewStudent.otherTrophozoites"></el-descriptions-item>
                        <el-descriptions-item label="REMARKS"><span class="mx-2" v-text="viewStudent.remarks"></el-descriptions-item>
                        <el-descriptions-item label="Pathologist"><span class="mx-2" v-text="viewStudent.pathologist"></el-descriptions-item>
                        <el-descriptions-item label="Medical Technologist"><span class="mx-2" v-text="viewStudent.technologist"></el-descriptions-item>
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
                Edit Hepa Antigen <span class="mx-2" v-text="editStudent.firstname"></span>
            </template>
            <el-form :label-position="leftLabel" label-width="160px" :model="updateStudent" :rules="editRules" ref="updateStudent">
                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
                        <el-form-item label="Identification Number" prop="identification">
                            <el-input v-model="updateStudent.identification" maxlength="7" onKeyup="addDashes(this)" disabled clearable></el-input>
                        </el-form-item>
                    </div>
                    <div class="col">
                        <el-form-item label="Year Level" prop="year">
                            <el-select v-model="updateStudent.year" placeholder="Select" id="selectYear" disabled>
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
                            <el-select v-model="updateStudent.classSection" placeholder="Select" disabled>
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
                            <el-input v-model="updateStudent.firstname" disabled clearable></el-input>
                        </el-form-item>
                    </div>
                    <div class="col">
                        <el-form-item label="Middle Name" prop="midname">
                            <el-input v-model="updateStudent.midname" disabled clearable></el-input>
                        </el-form-item>
                    </div>
                    <div class="col">
                        <el-form-item label="Last Name" prop="lastname">
                            <el-input v-model="updateStudent.lastname" disabled clearable></el-input>
                        </el-form-item>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
                        <el-form-item label="Phone No." prop="phone_number">
                            <el-input v-model="updateStudent.phone_number" disabled clearable></el-input>
                        </el-form-item>
                    </div>
                    <div class="col">
                        <el-form-item label="Birthday" prop="birthdate">
                            <el-date-picker :picker-options="birthdayOptions" v-model="updateStudent.birthdate" type="date" placeholder="Select birthdate" disabled clearable>
                            </el-date-picker>
                        </el-form-item>
                    </div>
                    <div class="col">
                        <el-form-item label="Gender" prop="gender" id="radioBtn">
                            <el-radio-group v-model="updateStudent.gender" disabled>
                                <el-radio-button label="Female" for="radioBtn"></el-radio-button>
                                <el-radio-button label="Male" for="radioBtn"></el-radio-button>
                            </el-radio-group>
                        </el-form-item>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
                        <el-form-item label="Request By" prop="requestBy">
                            <el-input v-model="updateStudent.requestBy" placeholder="Enter Request By" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Color" prop="color">
                            <el-input v-model="updateStudent.color" placeholder="Enter Color" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Consistency" prop="consistency">
                            <el-input v-model="updateStudent.consistency" placeholder="Enter Consistency" clearable>
                            </el-input>
                        </el-form-item>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
                        <el-form-item label="Occult" prop="occult">
                            <el-input v-model="updateStudent.occult" placeholder="Enter Occult" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Other Occult" prop="otherOccult">
                            <el-input v-model="updateStudent.otherOccult" placeholder="Enter Other Occult" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Pus" prop="pus">
                            <el-input v-model="updateStudent.pus" placeholder="Enter Pus" clearable>
                            </el-input>
                        </el-form-item>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
                        <el-form-item label="RBC" prop="rbc">
                            <el-input v-model="updateStudent.rbc" placeholder="Enter RBC" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Fat" prop="fat">
                            <el-input v-model="updateStudent.fat" placeholder="Enter Fat" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="OVA" prop="ova">
                            <el-input v-model="updateStudent.ova" placeholder="Enter OVA" clearable>
                            </el-input>
                        </el-form-item>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
                        <el-form-item label="Larva" prop="larva">
                            <el-input v-model="updateStudent.larva" placeholder="Enter Larva" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Adult" prop="adult">
                            <el-input v-model="updateStudent.adult" placeholder="Enter Adult" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Cyst" prop="cyst">
                            <el-input v-model="updateStudent.cyst" placeholder="Enter Cyst" clearable>
                            </el-input>
                        </el-form-item>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
                        <el-form-item label="Trophozoites" prop="trophozoites">
                            <el-input v-model="updateStudent.trophozoites" placeholder="Enter Trophozoites" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Other Trophozoites" prop="otherTrophozoites">
                            <el-input v-model="updateStudent.otherTrophozoites" placeholder="Enter Other Trophozoites" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Remarks" prop="remarks">
                            <el-input v-model="updateStudent.remarks" placeholder="Enter Remarks" clearable>
                            </el-input>
                        </el-form-item>
                    </div>
                </div>

                <div class="row justify-content-start align-items-center g-2">
                    <div class="col">
                        <el-form-item label="Pathologist" prop="pathologist">
                            <el-input v-model="updateStudent.pathologist" placeholder="Enter Pathologist" clearable>
                            </el-input>
                        </el-form-item>
                    </div>

                    <div class="col">
                        <el-form-item label="Technologist" prop="technologist">
                            <el-input v-model="updateStudent.technologist" placeholder="Enter Technologist" clearable>
                            </el-input>
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
    </div>
</div>
</body>
@include('nurse/imports/body')

</html>