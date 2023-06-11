@extends('admin/layout/fecal-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Fecalysis-form')
</head>

<body>
    @section('content')
    <div class="container-fluid" v-if="this.isFecalysis">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Fecalysis</h4>
                        <div class="row align-items-center g-2 my-2">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" v-model="this.firstname" disabled />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" v-model="midname" disabled />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" v-model="lastname" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center g-2 my-2">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Age</label>
                                    <input type="text" class="form-control" v-model="this.age" disabled />
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group mb-4">
                                    <label class="form-label">Gender</label>
                                    <input type="text" class="form-control" v-model="gender" disabled />
                                </div>
                            </div>
                        </div>
                        <hr>
                        <form class="mb-4" @submit.prevent="submitFecal">
                            @csrf
                            <div class="row align-items-center g-2 my-2">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Requested By:</label>
                                        <input type="text" class="form-control" v-model="requestBy" />
                                        <div class="text-danger" v-text="errors.requestBy"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Date of request:</label>
                                        <input type="date" class="form-control" v-model="formattedDate" disabled />
                                        <div class="text-danger" v-text="errors.requestDate"></div>
                                    </div>
                                </div>
                                <h5 class="text-success">PHYSICAL PROPERTIES</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Color:</label>
                                        <input type="text" class="form-control" v-model="color" />
                                        <div class="text-danger" v-text="errors.color"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Consistency:</label>
                                        <input type="text" class="form-control" v-model="consistency" />
                                        <div class="text-danger" v-text="errors.consistency"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <h5 class="text-success">CHEMICAL PROPERTIES</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Occult Blood:</label>
                                        <input type="text" class="form-control" v-model="occult" />
                                        <div class="text-danger" v-text="errors.occult"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Others:</label>
                                        <input type="text" class="form-control" v-model="otherOccult" />
                                    </div>
                                </div>
                                <h5 class="text-success">MICROSCOPIC FINDINGS</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Pus cells:</label>
                                        <input type="text" class="form-control" v-model="pus" />
                                        <div class="text-danger" v-text="errors.pus"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">RBC:</label>
                                        <input type="text" class="form-control" v-model="rbc" />
                                        <div class="text-danger" v-text="errors.rbc"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Fat GLobules:</label>
                                        <input type="text" class="form-control" v-model="fat" />
                                        <div class="text-danger" v-text="errors.fat"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <h5 class="text-success">HELMINTHS</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Ova:</label>
                                        <input type="text" class="form-control" v-model="ova" />
                                        <div class="text-danger" v-text="errors.ova"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Larva:</label>
                                        <input type="text" class="form-control" v-model="larva" />
                                        <div class="text-danger" v-text="errors.larva"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Adult Forms:</label>
                                        <input type="text" class="form-control" v-model="adult" />
                                        <div class="text-danger" v-text="errors.adult"></div>
                                    </div>
                                </div>
                                <h5 class="text-success">PROTOZOA</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Cyst:</label>
                                        <input type="text" class="form-control" v-model="cyst" />
                                        <div class="text-danger" v-text="errors.cyst"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Trophozoites:</label>
                                        <input type="text" class="form-control" v-model="trophozoites" />
                                        <div class="text-danger" v-text="errors.trophozoites"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Others:</label>
                                        <input type="text" class="form-control" v-model="otherTrophozoites" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <h5 class="text-dark">REMARKS</h5>
                                <textarea type="text" class="form-control" v-model="remarks"></textarea>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Pathologist:</label>
                                        <input type="text" class="form-control" v-model="pathologist" />
                                        <div class="text-danger" v-text="errors.pathologist"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Medical Technologist:</label>
                                        <input type="text" class="form-control" v-model="technologist" />
                                        <div class="text-danger" v-text="errors.technologist"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <button class="btn btn-outline-primary btn-sm me-2" @click="back"><i class="fas fa-arrow-circle-left pe-2"></i>Back</button>
                                <button class="btn btn-outline-primary btn-sm" type="submit">Submit <i class="fas fa-arrow-circle-right ps-2"></i></button>
                            </div>
                            <div class="mt-2 mb-4">
                                <div class="row justify-content-center align-items-center g-2">
                                    <div class="col">
                                        <div class="progress" :space="800" :active="active" finish-status="success">
                                            <div class="progress-bar bg-success" title="Step Finish" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Finish</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endsection
</body>
</html>