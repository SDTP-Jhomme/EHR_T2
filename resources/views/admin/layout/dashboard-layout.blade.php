<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/style.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/css/bootstrap.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo asset('storage/assets/fontawesome/css/all.min.css') ?>">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo asset('storage/assets/fontawesome/svgs/regular/credit-card.svg') ?>"><!-- CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<title>@yield('title')</title>
<!-- header -->
<header id="header" class="sticky-top nav-bg">
    <nav class="navbar">
        <div class="container-fluid d-flex align-items-center">
            <div class="me-3">
                <a class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="collapse" href="#sidebar" aria-expanded="false" aria-controls="sidebar">
                    <i class="fas fa-bars" style="color: #fff;"></i>
                </a>
                <a class="navbar-brand" href="#">School Name</a>
            </div>
            <div class="me-auto d-none d-lg-block">
                <h1 class="welcome-text">Good Morning, <span class="text-light fw-bold">John Doe</span></h1>
                <h3 class="welcome-sub-text">Your performance summary this week </h3>
            </div>
            <div class="nav">
                <li class="nav-item">
                    <div class="ms-auto mt-auto">
                        <div class="dropstart user-dropdown">
                            <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="img-xs rounded-circle" src="<?php echo asset('storage/assets/avatar/default.png') ?>" alt="Profile image"> </a>
                            <div class="dropdown-menu" aria-labelledby="UserDropdown">
                                <div class="dropdown-header text-center">
                                    <img class="img-md rounded-circle" src="<?php echo asset('storage/assets/avatar/default.png') ?>" alt="Profile image">
                                    <p class="mb-1 mt-3 fw-light text-muted">Allen Moreno</p>
                                </div>
                                <a class="dropdown-item">
                                    <i class="fas fa-power-off text-danger me-2"></i>
                                    Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </div>
        </div>
    </nav>
</header>
<!-- sidebar -->
<div class="container-fluid page-wrapper">
    <aside id="sidebar" class="collapse collapse-horizontal show sidebar">
        <ul class="nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('admin-dashboard')}}">
                    <i class="fas fa-th-large pe-2"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <!-- <li class="nav-item nav-category">Admissions</li> -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#students" aria-expanded="false" aria-controls="students">
                    <i class="fas fa-users pe-2"></i>
                    <span class="menu-title">Clients</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="students">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin-admission')}}"><i class="fas fa-user pe-2"></i>Admissions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/ui-features/dropdowns.html"><i class="fas fa-cog pe-2"></i>Activities</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#payment" aria-expanded="false" aria-controls="payment">
                    <i class="fas fa-cash-register pe-2"></i>
                    <span class="menu-title">Bill and Payment</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="payment">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="pages/ui-features/buttons.html"><i class="fas fa-money-bill-alt pe-2"></i>Payments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/ui-features/dropdowns.html"><i class="fas fa-receipt pe-2"></i>Reciepts</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </aside>
    @yield('sidebar')
</div>
<script src="<?php echo asset('storage/assets/js/bootstrap.bundle.js') ?>"></script>
<script src="<?php echo asset('storage/assets/js/main.js') ?>"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Get the canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Define the chart data
    var data = {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'Sample Dataset',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Set the bar color
            borderColor: 'rgba(75, 192, 192, 1)', // Set the border color
            borderWidth: 1 // Set the border width
        }]
    };

    // Create the chart
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>