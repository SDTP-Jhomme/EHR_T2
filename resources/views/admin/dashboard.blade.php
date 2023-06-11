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
                                    <div class="col-sm-12">
                                        <div class="statistics-details d-flex align-items-center justify-content-between">
                                            <div>
                                                <p class="statistics-title">Complete Blood Count</p>
                                                <h3 class="rate-percentage d-flex justify-content-between align-items-center"><i class="fas fa-user-circle me-3 text-muted"></i><span class="text-muted" v-text="this.cbcCount"></h3>
                                            </div>
                                            <div>
                                                <p class="statistics-title">Urinalysis</p>
                                                <h3 class="rate-percentage d-flex justify-content-between align-items-center" ><i class="fas fa-user-circle me-3 text-muted"></i><span class="text-muted" v-text="this.countUrine"></h3>
                                            </div>
                                            <div>
                                                <p class="statistics-title">Fecalysis</p>
                                                <h3 class="rate-percentage d-flex justify-content-between align-items-center"><i class="fas fa-user-circle me-3 text-muted"></i><span class="text-muted" v-text="this.countfecal"></h3>
                                            </div>
                                            <div class="d-none d-md-block">
                                                <p class="statistics-title">Chest X-ray (PA)</p>
                                                <h3 class="rate-percentage d-flex justify-content-between align-items-center"><i class="fas fa-user-circle me-3 text-muted"></i><span class="text-muted" v-text="this.countXray"></h3>
                                            </div>
                                            <div class="d-none d-md-block">
                                                <p class="statistics-title">Heppa B Antigen</p>
                                                <h3 class="rate-percentage d-flex justify-content-between align-items-center"><i class="fas fa-user-circle me-3 text-muted"></i><span class="text-muted" v-text="this.countAntigen"></h3>
                                            </div>
                                            <div class="d-none d-md-block">
                                                <p class="statistics-title">Heppa B Vaccine</p>
                                                <h3 class="rate-percentage d-flex justify-content-between align-items-center"><i class="fas fa-user-circle me-3 text-muted"></i><span class="text-muted" v-text="this.countVaccine"></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
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
                                        <div class="col-md-8 col-lg-4 d-flex flex-column">
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