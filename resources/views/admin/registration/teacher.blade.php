@extends('admin/layout/teacher-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('storage/assets/img/favicon.png') ?>">
    @section('title', 'Teacher-Admission')
</head>

<body>
    @section('sidebar')
    <main class="main-panel flex-lg-grow-1">
        <el-header class="mt-4" height="40">
            <div class="container p-0">
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-button type="primary" @click="openAddDrawer = true" size="small" icon="el-icon-user-solid">Add New Nurse</el-button>
                    </el-col>
                </el-row>
            </div>
        </el-header>
        <el-main>
            <div class="container border rounded p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="mb-0">Teacher Information Table</p>
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
                    <el-table-column sortable label="Full Name" width="220" prop="name">
                    </el-table-column>
                    <el-table-column sortable label="Avatar" width="200" prop="phone_number">
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
        <!-- Add Drawer -->
        <el-drawer title="Add Nurse" :visible.sync="openAddDrawer" size="70%" :before-close="closeAddDrawer">
            <div class="container p-4 d-flex flex-column pe-5">
                <el-form :label-position="topLabel" :model="addTeacher" :rules="rules" ref="addTeacher">
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col-4">
                            <el-form-item label="First Name" prop="firstname">
                                <el-input v-model="addTeacher.firstname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-4">
                            <el-form-item label="Middle Name" prop="midname">
                                <el-input v-model="addTeacher.midname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-4">
                            <el-form-item label="Last Name" prop="lastname">
                                <el-input v-model="addTeacher.lastname" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-4">
                            <el-form-item label="Email Address" prop="email">
                                <el-input v-model="addTeacher.email" clearable></el-input>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row justify-content-start align-items-center g-2">
                        <div class="col-4">
                            <el-form-item label="Phone Number" prop="phone_number">
                                <el-input v-model="addTeacher.phone_number" clearable></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-4">
                            <el-form-item label="Birthday" prop="birthdate">
                                <el-date-picker v-model="addTeacher.birthdate" type="date" placeholder="Select birthdate" :picker-options="birthdayOptions"clearable>
                                </el-date-picker>
                            </el-form-item>
                        </div>
                        <div class="col-4">
                            <el-form-item label="Gender" prop="gender">
                                <el-radio-group v-model="addTeacher.gender">
                                    <el-radio-button label="Female"></el-radio-button>
                                    <el-radio-button label="Male"></el-radio-button>
                                </el-radio-group>
                            </el-form-item>
                        </div>
                    </div>
                </el-form>
            </div>
            <div class="d-flex p-4">
                <el-button :loading="loadButton" class="flex-1" type="primary" @click="addUser('addTeacher')">Submit</el-button>
                <el-button :loading="loadButton" class="flex-1" @click="resetForm('addTeacher')">Reset</el-button>
            </div>
        </el-drawer>
        <!-- After Add Show Teacher Username & Password -->
        <el-dialog title="New Teacher Username and Password" :visible.sync="openAddDialog" width="30%" :before-close="closeAddDialog">
            <label>Identification</label>
            <el-input class="mb-2" v-model="newUser.email" disabled></el-input>
            <label>Password</label>
            <el-input class="mb-2" v-model="newUser.password" disabled></el-input>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="closeAddDialog">Close</el-button>
            </span>
        </el-dialog>
        <!-- View Dialog -->
        <el-dialog :visible.sync="viewDialog" width="35%" :before-close="closeViewDialog">
            <template #title>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fs-5">User<span class="mx-2" v-text="viewTeacher.firstname"></span></div>
                    <div class="pe-4">
                        <el-avatar :size="70" :src="viewTeacher.avatar"></el-avatar>
                    </div>
                </div>
            </template>
            <div class="container">
                <div class="">
                    <el-descriptions direction="horizontal" :column="1" border>
                        <el-descriptions-item label="Email Address"><span class="mx-2" v-text="viewTeacher.email"></el-descriptions-item>
                        <el-descriptions-item label="Name"><span class="mx-2" v-text="viewTeacher.name"></el-descriptions-item>
                        <el-descriptions-item label="Birthday"><span class="mx-2" v-text="viewTeacher.birthdate"></el-descriptions-item>
                        <el-descriptions-item label="Gender">
                            <el-tag v-if="viewTeacher.gender == 'Male'"><span class="mx-2" v-text="viewTeacher.gender"></el-tag>
                            <el-tag v-else type="danger"><span class="mx-2" v-text="viewTeacher.gender"></el-tag>
                        </el-descriptions-item>
                    </el-descriptions>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="primary" @click="closeViewDialog">Close</el-button>
            </span>
        </el-dialog>
        <!-- Edit Dialog -->
        <el-dialog :visible.sync="editDialog" width="40%" :before-close="closeEditDialog">
            <template #title>
                Edit User <span class="mx-2" v-text="editTeacher.firstname"></span>
            </template>
            <el-form :label-position="leftLabel" label-width="160px" :model="updateTeacher" :rules="editRules" ref="updateTeacher">
                <el-form-item label="Email Address" prop="email">
                    <el-input v-model="updateTeacher.email" clearable></el-input>
                </el-form-item>
                <el-form-item label="First Name" prop="firstname">
                    <el-input v-model="updateTeacher.firstname" clearable></el-input>
                </el-form-item>
                <el-form-item label="Middle Name" prop="midname">
                    <el-input v-model="updateTeacher.midname" clearable></el-input>
                </el-form-item>
                <el-form-item label="Last Name" prop="lastname">
                    <el-input v-model="updateTeacher.lastname" clearable></el-input>
                </el-form-item>
                <el-form-item label="Phone No." prop="phone_number">
                    <el-input v-model="updateTeacher.phone_number" clearable></el-input>
                </el-form-item>
                <el-form-item label="Birthday" prop="birthdate">
                    <el-date-picker :picker-options="birthdayOptions" v-model="updateTeacher.birthdate" type="date" placeholder="Select birthdate" clearable>
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="Gender" prop="gender">
                    <el-radio-group v-model="updateTeacher.gender">
                        <el-radio-button label="Female"></el-radio-button>
                        <el-radio-button label="Male"></el-radio-button>
                    </el-radio-group>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button :loading="loadButton" @click="closeEditDialog('updateTeacher')">Cancel</el-button>
                <el-button :loading="loadButton" type="primary" @click="updateUser('updateTeacher')">Update</el-button>
            </span>
        </el-dialog>
    </main>
    @endsection
</body>

</html>