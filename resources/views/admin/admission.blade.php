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
                            <el-button type="text" @click="dialogTableVisible = true">open a Table nested Dialog</el-button>
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
                <div class="container">
                    <el-dialog title="Shipping address" :visible.sync="dialogTableVisible">
                    <el-table :data="gridData">
                        <el-table-column property="date" label="Date" width="150"></el-table-column>
                        <el-table-column property="name" label="Name" width="200"></el-table-column>
                        <el-table-column property="address" label="Address"></el-table-column>
                    </el-table>
                    <div class="row justify-content-center align-items-center g-2">
                        <div class="col-lg-3 col-md-8 me-5">
                            <el-date-picker
                            v-model="dateRange"
                            type="daterange"
                            start-placeholder="Start Date"
                            end-placeholder="End Date"
                            :picker-options="reportOptions">
                            </el-date-picker>
                        </div>
                        <div class="col-lg-3 col-md-8">
                            <el-button type="primary" @click="printTable" round>Print Table</el-button>
                        </div>
                    </div>
                    </el-dialog>
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