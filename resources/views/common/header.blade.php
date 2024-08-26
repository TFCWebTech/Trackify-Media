<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>News Report System</title>

    <!-- Custom fonts for this template-->
    <!-- <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css"> -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
   
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        label {
            font-size: 0.9rem !important;
        }
        .form-control {
            font-size: .8rem !important;
        }
        /* Custom border with text */
        .border-with-text {
            position: relative;
            padding: 20px;
            border: 2px solid #5a5c6926; /* Blue border */
            border-radius: 10px;
        }

        .border-with-text::before {
            content: attr(data-heading);
            position: absolute;
            top: -12px; /* Adjusts the position of the text */
            left: 20px; /* Adjusts the left position */
            background: white;
            padding: 0 10px; /* Padding for the background */
            font-weight: bold;
            color: #224abecc; /* Matches the border color */
        }
        .text-color {
            color: #224abecc;
        }
        label {
            margin-bottom: 0rem !important;
            margin-top: 0.7rem !important;
        }
        .btn {
            padding: .175rem .55rem !important;
            font-weight: 600 !important;
            text-transform: uppercase;
        }

        table.dataTable thead th, table.dataTable thead td {
            border-bottom: 1px solid #5a5c6926 !important;
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid #5a5c6926 !important;
        }
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-size: 0.8rem !important;
        }
        .modal-title {
            font-size: 1.2rem !important;
            text-transform: uppercase !important;
        }
        #toast-container .toast-error {
    background-color: red !important;
    color: #fff !important;
}
#toast-container .toast-success {
    background-color: blue !important;
    color: #fff !important;
}
.btn {
    font-size: .8rem !important;
}

    </style>
</head>

<body id="page-top" onload="setDefaultDate()">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" >
                <div class="sidebar-brand-icon rotate-n-15">
                   <!-- <i class="fas fa-laugh-wink"></i>-->
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            @if(session()->has('user_id'))
@if(session()->get('user_type') == 'Reporter')
    <li class="nav-item {{ request()->routeIs('news_upload') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('news_upload') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>News Upload</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('reporte.account') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reporte.account') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Manage Account</span>
        </a>
    </li>
@endif

@if(session()->get('user_type') == 'Admin')
    <li class="nav-item {{ request()->routeIs('news_latter') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('news_latter') }}">
            <i class="fa fa-newspaper-o"></i>
            <span>Manage Newsletter</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('repoter') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('repoter') }}">
            <i class="fa fa-user-circle-o"></i>
            <span>Manage Reporter</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('client') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('client') }}">
            <i class="fa fa-building-o"></i>
            <span>Manage Client</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('industry') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('industry') }}">
            <i class="fa fa-industry"></i>
            <span>Manage Industry</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('edition') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('edition') }}">
            <i class="fas fa-city"></i>
            <span>Manage Edition</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('supplement') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('supplement') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Manage Supplements</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('publication') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('publication') }}">
            <i class="fa fa-book"></i>
            <span>Manage Publication</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('journalist') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('journalist') }}">
            <i class="fa fa-newspaper-o"></i>
            <span>Manage Journalist</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('addRate') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('addRate') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Manage AddRate</span>
        </a>
    </li>
@endif

@if(session()->get('user_type') == 'Client')
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('compare_charts') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('compare_charts') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Pro Compare</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('report') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('report') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Pro Report</span>
        </a>
    </li>
@endif
@endif
 

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

           <!-- Sidebar Toggler (Sidebar) -->
           <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    @if(session('user_id'))
                                        <div>
                                            Welcome, {{ session('user_name') }} 
                                        </div>
                                    @else
                                        <div>
                                            Please log in.
                                        </div>
                                    @endif
                                </span>
                    </span>
                    <img class="img-profile rounded-circle"
    src="{{ asset('assets/img/undraw_profile.svg') }}">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                                           
                    <!-- <div class="dropdown-divider"></div> -->
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" >
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- End of Topbar -->

