@extends('nurse/layout/urinalysis-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Urinalysis-form')
</head>

<body>
    @section('content')
    <div class="container-fluid" v-if="this.isUrinalysis">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Urinalysis</h4>
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
                        <form class="mb-4" @submit.prevent="submitUrinalysis">
                            @csrf
                            <div class="row align-items-center g-2 my-2">
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
                                        <label class="form-label">Transparency:</label>
                                        <input type="text" class="form-control" v-model="transparency" />
                                        <div class="text-danger" v-text="errors.transparency"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Specific Gravity:</label>
                                        <input type="text" class="form-control" v-model="gravity" />
                                        <div class="text-danger" v-text="errors.gravity"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <h5 class="text-success">CHEMICAL ANALYSIS</h5>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Ph:</label>
                                        <input type="text" class="form-control" v-model="ph" />
                                        <div class="text-danger" v-text="errors.ph"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Sugar:</label>
                                        <input type="text" class="form-control" v-model="sugar" />
                                        <div class="text-danger" v-text="errors.sugar"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Protein:</label>
                                        <input type="text" class="form-control" v-model="protein" />
                                        <div class="text-danger" v-text="errors.protein"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Pregnancy Test:</label>
                                        <input type="text" class="form-control" v-model="pregnancy" />
                                        <div class="text-danger" v-text="errors.pregnancy"></div>
                                    </div>
                                </div>
                                <h5 class="text-success">MICROSCOPIC EXAMINATION</h5>
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
                                        <label class="form-label">Cast:</label>
                                        <input type="text" class="form-control" v-model="cast" />
                                        <div class="text-danger" v-text="errors.cast"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-2 my-2">
                                <h5 class="text-success">CRYSTAL</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Urates:</label>
                                        <input type="text" class="form-control" v-model="urates" />
                                        <div class="text-danger" v-text="errors.urates"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Uric Acid:</label>
                                        <input type="text" class="form-control" v-model="uric" />
                                        <div class="text-danger" v-text="errors.uric"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Cal Ox:</label>
                                        <input type="text" class="form-control" v-model="cal" />
                                        <div class="text-danger" v-text="errors.cal"></div>
                                    </div>
                                </div>
                                <h5 class="text-success">OTHERS</h5>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Epith Cells:</label>
                                        <input type="text" class="form-control" v-model="epith" />
                                        <div class="text-danger" v-text="errors.epith"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Mucus Threads:</label>
                                        <input type="text" class="form-control" v-model="mucus" />
                                        <div class="text-danger" v-text="errors.mucus"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group mb-4">
                                        <label class="form-label">Others:</label>
                                        <input type="text" class="form-control" v-model="otherOthers" />
                                    </div>
                                </div>
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