@extends('admin/layout/dashboard-layout')
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo asset('storage/assets/img/favicon.png') ?>">
    @section('title', 'Dashboard')
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
                                <div class="col-sm-12">
                                    <div class="statistics-details d-flex align-items-center justify-content-between">
                                        <div>
                                            <p class="statistics-title">Bounce Rate</p>
                                            <h3 class="rate-percentage">32.53%</h3>
                                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>-0.5%</span></p>
                                        </div>
                                        <div>
                                            <p class="statistics-title">Page Views</p>
                                            <h3 class="rate-percentage">7,682</h3>
                                            <p class="text-success d-flex"><i class="mdi mdi-menu-up"></i><span>+0.1%</span></p>
                                        </div>
                                        <div>
                                            <p class="statistics-title">New Sessions</p>
                                            <h3 class="rate-percentage">68.8</h3>
                                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68.8</span></p>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">Avg. Time on Site</p>
                                            <h3 class="rate-percentage">2m:35s</h3>
                                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">New Sessions</p>
                                            <h3 class="rate-percentage">68.8</h3>
                                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68.8</span></p>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="statistics-title">Avg. Time on Site</p>
                                            <h3 class="rate-percentage">2m:35s</h3>
                                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
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
                                                                <h4 class="card-title card-title-dash">Market Overview</h4>
                                                                <p class="card-subtitle card-subtitle-dash">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                                            <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                                                <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                                                <h4 class="me-2">USD</h4>
                                                                <h4 class="text-success">(+1.37%)</h4>
                                                            </div>
                                                            <div class="me-3">
                                                                <div id="marketing-overview-legend"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <canvas class="" id="myChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
@endsection

</html>