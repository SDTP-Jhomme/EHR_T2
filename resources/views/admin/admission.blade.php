@extends('admin/layout/admission-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @section('title', 'Admission')
</head>

<body>
    @section('sidebar')
    <main class="main-panel flex-lg-grow-1">
        <div class="container-fluid">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="home-tab">
                            <div class="row">
                                <div class="row">
                                    <div class="col-lg-8 d-flex flex-column">
                                        <div class="row flex-grow">
                                            <div class="col-12 grid-margin stretch-card">
                                                <div class="card w-100 rounded">
                                                    <div class="card-body">
                                                        <div class="d-sm-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h4 class="card-title card-title-dash">Clients Overview
                                                                </h4>
                                                                <p class="card-subtitle card-subtitle-dash">Lorem ipsum
                                                                    dolor sit amet consectetur adipisicing elit</p>
                                                            </div>
                                                            <div>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#addClient" aria-controls="addClient">
                                                                    <i class="fas fa-user-plus pe-2"></i>
                                                                    Add new clients
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="table-responsive mt-1">
                                                            <table class="table table-hover select-table">
                                                                <thead class="thead">
                                                                    <tr>
                                                                        <th>
                                                                            <div class="form-check form-check-flat mt-0">
                                                                                <label class="form-check-label">
                                                                                    <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                                                            </div>
                                                                        </th>
                                                                        <th>Student</th>
                                                                        <th>Year</th>
                                                                        <th>Course</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-check form-check-flat mt-0">
                                                                                <label class="form-check-label">
                                                                                    <input type="checkbox" class="form-check-input" aria-checked="false"><i class="input-helper"></i></label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex ">
                                                                                <img src="<?php echo asset('storage/assets/avatar/default.png') ?>" alt="">
                                                                                <div>
                                                                                    <h6>Name</h6>
                                                                                    <p>Student</p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <h6>Year</h6>
                                                                            <p>section</p>
                                                                        </td>
                                                                        <td>
                                                                            <h6>Course</h6>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge badge-opacity-warning">In
                                                                                progress</span>
                                                                        </td>
                                                                        <td>
                                                                            <div class="">
                                                                                <button type="button" class="btn-sm btn-primary me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View"><i class="fas fa-eye"></i></button>
                                                                                <button type="button" class="btn-sm btn-warning me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="fas fa-edit text-light"></i></button>
                                                                                <button type="button" class="btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete"><i class="fas fa-trash"></i></button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-6">
                                        <table id="myTable" class="table table-hover" height="400">
                                            <div class="form-group input-group float-end w-25 ">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-danger">
                                                        <i class="fas fa-search p-2 px-3 text-light"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="searchInput">
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th class="col-1">No</th>
                                                    <th class="col-3">username</th>
                                                    <th class="col-3">password</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addClient" aria-labelledby="offcanvasNavbarLabel">
        <button type="button" class="btn-close text-reset m-2 ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <div class="margin-top">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">New Admission</h5>
            </div>
            <hr>
            <div class="offcanvas-body">
                <form id="adduser-form" class="">
                    <div class="input-group mb-4">
                        <span class="input-group-text group-text">Identification</span>
                        <input type="text" class="form-control" id="identification" name="identification" placeholder="Identification" aria-label="Identification" aria-describedby="identification">
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text group-text">First Name</span>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" aria-label="First Name" aria-describedby="firstname">
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text group-text">Middle Name <span class="text-muted card-subtitle ps-2">(optional)</span></span>
                        <input type="text" class="form-control" id="midname" name="midname" placeholder="Middle Name" aria-label="Middle Name" aria-describedby="midname">
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text group-text">Last Name</span>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" aria-label="Last Name" aria-describedby="lastname">
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text group-text me-3">Gender</span>
                        <div class="mx-3">
                            <input type="radio" class="btn-check" name="gender" id="gender" autocomplete="off">
                            <label class="btn btn-outline-primary" for="gender">Male</label>
                            <input type="radio" class="btn-check" name="gender" id="gender" autocomplete="off">
                            <label class="btn btn-outline-danger" for="gender">Female</label>
                        </div>
                    </div>
                    <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                        <span class="input-group-text group-text">Date of Birth</span>
                        <input type="date" class="form-control" id="birthdate":picker-options="datePickerOptions" name="birthdate" placeholder="Date of Birth" aria-label="Date of Birth" aria-describedby="birthdate">
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" id="btn-login" class="btn-login">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>