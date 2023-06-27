@extends('admin/layout/dashboard-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin/imports/head')
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('assets/img/favicon.png') ?>">
    @section('title', 'Dashboard')
</head>

<body>
<div id="app">
    <div v-if="fullscreenLoading" class="fullscreen-loading">
        <div class="spinner-heart" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span class="spinner-text">Loading...</span>
    </div>
@include('admin/imports/nav')
    <div class="container-fluid page-wrapper">
    @include('admin/imports/sidebar')
        <main class="main-panel flex-lg-grow-1">
            <div class="container-fluid">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="home-tab">
                                <div class="row">
                                    <div class="row justify-content-between align-items-center g-2 mb-3">
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/cbc.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Complete Blood Count</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.cbcCount"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/urinalysis.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Urinalysis</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countUrine"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/fecalysis.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Fecalysis</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countfecal"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between align-items-center g-2 mb-4">
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/x-ray.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Chest X-ray (PA)</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countXray"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/hepa-antigen.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Heppa B Antigen</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countAntigen"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-8">
                                            <div class="card">
                                                <img class="card-img-top w-25 mx-auto" src="<?php echo asset('assets/img/hepa-vaccine.png') ?>" alt="Title">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title">Heppa B Vaccine</h4>
                                                    <p class="card-text fs-2"><i class="fas fa-poll me-3 text-muted"></i><span class="text-muted" v-text="this.countVaccine"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="row mt-4">
                                        <div class="col-lg-8 d-flex flex-column">
                                            <div class="row flex-grow-1">
                                                <div class="col-12 grid-margin stretch-card">
                                                    <div class="card w-100 rounded">
                                                        <div class="card-body">
                                                            <div class="d-sm-flex justify-content-between align-items-start">
                                                                <div>
                                                                    <h4 class="card-title card-title-dash">Registration Overview</h4>
                                                                    <p class="card-subtitle card-subtitle-dash">Monthly data</p>
                                                                </div>
                                                            </div>
                                                            <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                                <div class="me-3">
                                                                    <div id="marketing-overview-legend"></div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-3">
                                                                <canvas ref="chartCanvas" id="formChart" style="height: 370px; width: 95%;"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-lg-4 d-flex flex-column">
                                            <div class="card w-100 rounded">
                                                <div class="card-body">
                                                    <div class="d-sm-flex justify-content-between align-items-start border-bottom">
                                                        <div>
                                                            <h4 class="card-title card-title-dash text-muted">Medical Records Overview</h4>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <canvas ref="chartPie"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
</div>
</div>
</body>

</html>