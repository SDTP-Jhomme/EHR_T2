@extends('admin/layout/admission-layout')
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
                <div class="container" id="myTable" >
                </div>
            </div>
        </el-main>
        <!----------------------------------------------------------------------------------- Modals/Drawers ----------------------------------------------------------------------------------->
        <!-- Add Student Drawer -->
        <el-drawer title="Add Student" :visible.sync="openAddDrawer" size="50%" :before-close="closeAddDrawer">
            <div class="container m-0">
                <el-form :label-position="topLabel" :model="addStudent" :rules="rules" ref="addStudent">
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col">
                            <el-form-item label="Identification Number" prop="identification">
                                <el-input v-model="addStudent.identification" maxlength="7" onKeyup="addDashes(this)" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-auto">
                            <el-form-item label="Year Level" prop="year">
                                <el-select v-model="addStudent.year" placeholder="Select Year Level">
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
                        <div class="col-auto">
                            <el-form-item label="Section" prop="classSection">
                                <el-select v-model="addStudent.classSection" placeholder="Select Class Section">
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
                                <el-input v-model="addStudent.firstname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Middle Name" prop="midname">
                                <el-input v-model="addStudent.midname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Last Name" prop="lastname">
                                <el-input v-model="addStudent.lastname" clearable></el-input>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col-auto">
                            <el-form-item label="Citizenship" prop="citizen">
                                <el-select v-model="addStudent.citizen" placeholder="Select Citizenship">
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
                                <el-select v-model="addStudent.civil" placeholder="Select Civil Status">
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
                                <el-input v-model="addStudent.phone_number" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Birthday" prop="birthdate">
                                <el-date-picker v-model="addStudent.birthdate" type="date" placeholder="Select birthdate" :picker-options="birthdayOptions"clearable>
                                </el-date-picker>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Gender" prop="gender">
                                <el-radio-group v-model="addStudent.gender">
                                    <el-radio-button label="Female"></el-radio-button>
                                    <el-radio-button label="Male"></el-radio-button>
                                </el-radio-group>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col">
                            <el-form-item label="Street No. and Street Address" prop="street">
                                <el-input v-model="addStudent.street" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Barangay" prop="brgy">
                                <el-input v-model="addStudent.brgy" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col">
                            <el-form-item label="Municipality/City" prop="city">
                                <el-input v-model="addStudent.city" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="row justify-content-start align-items-center g-2">
                            <div class="col">
                                <el-form-item label="Contact Person First Name" prop="guardianFname">
                                    <el-input v-model="addStudent.guardianFname" clearable></el-input>
                                </el-form-item>
                            </div>
                            <div class="col">
                                <el-form-item label="Contact Person Middle Name(optional)" prop="guardianMname">
                                    <el-input v-model="addStudent.guardianMname" clearable></el-input>
                                </el-form-item>
                            </div>
                            <div class="col">
                                <el-form-item label="Contact Person Last Name" prop="guardianLname">
                                    <el-input v-model="addStudent.guardianLname" clearable></el-input>
                                </el-form-item>
                            </div>
                        </div>
                        <div class="row justify-content-start align-items-center g-2">
                            <div class="col-4">
                                <el-form-item label="Contact Person Phone Number" prop="guardianPhone_number">
                                    <el-input v-model="addStudent.guardianPhone_number" clearable></el-input>
                                </el-form-item>
                            </div>
                        </div>
                    </div>
                </el-form>
            </div>
            <div class="d-flex p-4">
                <el-button :loading="loadButton" class="flex-1" type="primary" @click="addUser('addStudent')">Submit</el-button>
                <el-button :loading="loadButton" class="flex-1" @click="resetForm('addStudent')">Reset</el-button>
            </div>
        </el-drawer>
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