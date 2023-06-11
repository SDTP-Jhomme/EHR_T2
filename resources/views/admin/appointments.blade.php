@extends('admin/layout/appointments-layout')
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
            <div class="container border rounded p-4">
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
                            <div v-else>
                                <el-input v-model="searchNull" size="mini" placeholder="Type to search..." clearable />
                            </div>
                        </div>
                    </div>
                </div>
                <el-table v-if="this.tableData" :data="usersTable" style="width: 100%" border height="400" v-loading="tableLoad" element-loading-text="Loading. Please wait..." element-loading-spinner="el-icon-loading">
                    <el-table-column label="No." type="index" width="50">
                    </el-table-column>
                    <el-table-column sortable label="Identification No." width="200" prop="identification">
                    </el-table-column>
                    <el-table-column sortable label="Full Name" width="220" prop="name">
                    </el-table-column>
                    <el-table-column sortable label="Year and Section" width="220" prop="yearandsection">
                        <template slot-scope="scope">
                            <el-tag size="small" v-if="scope.row.year == 'Fourth Year'"><span v-text="scope.row.yearandsection"></span></el-tag>
                            <el-tag size="small" type="warning" v-if="scope.row.year == 'First Year'"><span v-text="scope.row.yearandsection"></span></el-tag>
                            <el-tag size="small" type="success" v-if="scope.row.year == 'Second Year'"><span v-text="scope.row.yearandsection"></span></el-tag>
                            <el-tag size="small" v-if="scope.row.year == 'Third Year'" type="danger"><span v-text="scope.row.yearandsection"></span></el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column sortable label="Birthdate" width="200" prop="birthdate">
                    </el-table-column>
                    <el-table-column sortable label="Gender" width="150" prop="gender">
                        <template slot-scope="scope">
                            <el-tag size="small" v-if="scope.row.gender == 'Male'"><span v-text="scope.row.gender"></span></el-tag>
                            <el-tag size="small" v-else type="danger"><span v-text="scope.row.gender"></span></el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column sortable label="Height" width="150" prop="height">
                    </el-table-column>
                    <el-table-column sortable label="Weight" width="150" prop="weight">
                    </el-table-column>
                    <el-table-column sortable label="Section" width="200" prop="section">
                    </el-table-column>
                    <el-table-column sortable label="Next Appointment" width="200" prop="next_appointment">
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