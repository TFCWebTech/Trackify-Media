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
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small" style="cursor: pointer;" onclick="toggleDropdown()">
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
        <img class="img-profile rounded-circle" src="{{ asset('assets/img/undraw_profile.svg') }}">
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" id="userDropdownMenu">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
        </a>
    </div>
</li>

<script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('userDropdownMenu');
        dropdownMenu.classList.toggle('show');
    }
</script>
        </ul>
    </nav>
    <!-- End of Topbar -->
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap (Optional) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
   
.table-wrapper {
    overflow-x: auto;
}

table {
    border-collapse: collapse;
    width: 100%;
}

td {
    padding: 5px;
    width: 33%;
}

th {
    text-align: center;
    padding: 5px;
}

.table-wrapper > table,
.table-wrapper > table td,
.table-wrapper > table th {
    border: 2px solid #ffffff;
}
.header_contert {
            display: flex;
            justify-content: space-between;
        }

        @media (max-width: 725px) {
            .header_contert {
                display: block;
                text-align: center;
            }
        }
        p{
            margin-top:0px !important;
            margin-bottom:0px !important;
        }
        h5 , h6{
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }
        #generatePDF , .send-button, #edit, #getEmailButton{
            background-color: #0080FF ;
            color: #ffffff;
            border-color: #0080FF ;
            border-radius: 5px;
        }
        .fa-send-o {
            font-size:16px;
        }
        .showEdit {
            display: none;
        }
</style>
<div class="container">
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('error') }}
    </div>
@endif
        <div class="row" id="hideThis">
            <div class="col-md-12 text-right mb-2">
                <!-- <button id="generatePDF"> <i class="fa fa-download"></i></button> &nbsp; -->
                <button id="edit" onclick="editFuncation()"> <i class="fa fa-edit"></i></button> &nbsp;
                <button id="getEmailButton" onclick="getEmail('{{ $details['client_id'] }}')"> <i class="fa fa-send-o"></i>
                </button> 
            </div>
        </div>
        <div class="card" id="content" style="background-color: #F9F9F9;">
                <div class="header" style="background-color: {{ $get_client_details[0]['header_background_color'] }}; padding:5px 10px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="left">   
                            @if ($get_client_details[0]['logo_position'] == 'Left') 
                                <img src="{{ $get_client_details[0]['header_logo_url']; }}" alt="logo" style="width:100px;"> <br>
                            @endif
                            @if ($get_client_details[0]['trackify_link_status'] == 1) 
                                <a href="{{ $get_client_details[0]['trackify_link']; }}" style="font-size:12px; color:#000000;">powered by trackify media</a>
                            @endif
                            </td>
                            </td>
                            <td align="center">
                            @if ($get_client_details[0]['logo_position'] == 'Center') 
                                <img src="{{ $get_client_details[0]['header_logo_url']; }}" alt="logo" style="width:100px;"> <br>
                            @endif
                                <h5 ><a style="font-size:{{  $get_client_details[0]['header_title_font_size'] }}px; color:{{ $get_client_details[0]['header_title_font_color'] }};"> {{ $get_client_details[0]['header_title_name']; }} </a><br>
                                <span style="display:block; font-size: 12px;">{{ date('l, M d, Y'); }}<br>
                                </span>
                            </h5>
                            </td>
                            <td align="right"> 
                                @if ($get_client_details[0]['logo_position'] == 'Right') 
                                    <img src="{{ $get_client_details[0]['header_logo_url']; }}" alt="logo" style="width:100px;"> <br>
                               @endif
                            </td>
                        </tr>
                    </table>
                </div>    
                <hr>
                <div class="col-md-12 mt-3 table-wrapper" >
                <table>
                    <tr style="background-color: #6D6B6B; color: #ffffff;">
                        <th>Quick Links</th>
                        <th>Access Other Services</th>
                    </tr>
                    @if (!empty($get_client_details[0]['get_quick_links']))
                        @foreach ($get_client_details[0]['get_quick_links'] as $detail)
                            @if ($detail->quick_links_position == '1')
                                @php
                                    $totalNewsCount = 0;
                                    if (!empty($get_client_details[0]['client_news'])) {
                                        foreach ($get_client_details[0]['client_news'] as $clientNews) {
                                            if (!empty($clientNews['news']) && is_array($clientNews['news'])) {
                                                $totalNewsCount += count($clientNews['news']);
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background-color: #DCD5D5; color: #ffffff;" onclick="scrollToTarget('clientdiv')">
                                    <td>
                                        <p>{{ $detail->quick_links_name }} ({{ $totalNewsCount }})</p>
                                    </td>
                                    <td><a href="#">Login</a></td>
                                </tr>
                            @elseif ($detail->quick_links_position == '2')
                                @php
                                    $totalCompetitorNewsCount = 0;
                                    if (!empty($get_client_details[0]['compititors_data'])) {
                                        foreach ($get_client_details[0]['compititors_data'] as $competitor) {
                                            if (!empty($competitor['news']) && is_array($competitor['news'])) {
                                                $totalCompetitorNewsCount += count($competitor['news']);
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background-color: #DCD5D5; color: #ffffff;" onclick="scrollToTarget2('competitordiv')">
                                    <td>
                                        {{ $detail->quick_links_name }} ({{ $totalCompetitorNewsCount }})
                                    </td>
                                    <td></td>
                                </tr>
                            @elseif ($detail->quick_links_position == '3')
                                @php
                                    $totalIndustryNewsCount = 0;
                                    if (!empty($get_client_details[0]['industry_data'])) {
                                        foreach ($get_client_details[0]['industry_data'] as $industry) {
                                            if (!empty($industry['news']) && is_array($industry['news'])) {
                                                $totalIndustryNewsCount += count($industry['news']);
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background-color: #DCD5D5; color: #ffffff;" onclick="scrollToTarget3('industrydiv')">
                                    <td>
                                        {{ $detail->quick_links_name }} ({{ $totalIndustryNewsCount }})
                                    </td>
                                    <td></td>
                                </tr>
                            @elseif ($detail->quick_links_position == '4')
                                @php
                                    $totalCompetitorNewsCount = 0;
                                    if (!empty($get_client_details[0]['compititors_data'])) {
                                        foreach ($get_client_details[0]['compititors_data'] as $competitor) {
                                            if (!empty($competitor['news']) && is_array($competitor['news'])) {
                                                $totalCompetitorNewsCount += count($competitor['news']);
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background-color: #DCD5D5; color: #ffffff;" onclick="scrollToTarget2('competitordiv')">
                                    <td>
                                        {{ $detail->quick_links_name }} ({{ $totalCompetitorNewsCount }})
                                    </td>
                                    <td></td>
                                </tr>
                            @elseif ($detail->quick_links_position == '5')
                                @php
                                    $totalIndustryNewsCount = 0;
                                    if (!empty($get_client_details[0]['industry_data'])) {
                                        foreach ($get_client_details[0]['industry_data'] as $industry) {
                                            if (!empty($industry['news']) && is_array($industry['news'])) {
                                                $totalIndustryNewsCount += count($industry['news']);
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background-color: #DCD5D5; color: #ffffff;" onclick="scrollToTarget3('industrydiv')">
                                    <td>
                                        {{ $detail->quick_links_name }} ({{ $totalIndustryNewsCount }})
                                    </td>
                                    <td></td>
                                </tr>
                            @elseif ($detail->quick_links_position == '6')
                                @php
                                    $totalCompetitorNewsCount = 0;
                                    if (!empty($get_client_details[0]['compititors_data'])) {
                                        foreach ($get_client_details[0]['compititors_data'] as $competitor) {
                                            if (!empty($competitor['news']) && is_array($competitor['news'])) {
                                                $totalCompetitorNewsCount += count($competitor['news']);
                                            }
                                        }
                                    }
                                @endphp
                                <tr style="background-color: #DCD5D5; color: #ffffff;" onclick="scrollToTarget2('competitordiv')">
                                    <td>
                                        {{ $detail->quick_links_name }} ({{ $totalCompetitorNewsCount }})
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">No Quick Links found.</td>
                        </tr>
                    @endif
                    <tr style="background-color: #DCD5D5; color: #ffffff;">
                        <td></td>
                        <td><a href="#">Customerservice@trackifyMedia.info</a></td>
                    </tr>
                </table>    
                </div>
                <div class="body-content" style="padding:10px 15px 0px 15px;"  id="clientdiv">
                    <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;"> {{ $details['client_name'] }} </h4>
                    @php
                        $hasNews = false;
                        if (!empty($get_client_details[0]['client_news'])) {
                            foreach ($get_client_details[0]['client_news'] as $news2) {
                                if (!empty($news2['news']) && is_array($news2['news']) && count($news2['news']) > 0) {
                                    $hasNews = true;
                                    break;
                                }
                            }
                        }
                    @endphp
                    @if ($hasNews)
                        @foreach ($get_client_details[0]['client_news'] as $key => $news2)
                            @if (!empty($news2['news']) && is_array($news2['news']))
                                @foreach ($news2['news'] as $news)
                                <div id="clientnewsContent-{{ $news['news_details_id'] }}" style="display: block;">
                                    <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                                        <h5>
                                            <a href="{{ url('news-article/'.$news['news_details_id']) }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}; font-family: {{ $get_client_details[0]['content_headline_font'] }}">  {{ $news['head_line'] }} </a>
                                        </h5>
                                        <h6 class="showEdit">
                                            <div style="d-flex">
                                                <a onclick="toggleNewsContent('{{ $news['news_details_id'] }}')"> Edit News</a>|
                                                <a onclick="hideNews('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')"> Hide</a> | 
                                                <a style="color:red;" onclick="deleteNews('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')">Delete</a> 
                                            </div>
                                        </h6>
                                    </div>
                                    <h6>Summary:</h6>
                                    <p style="color: {{ $get_client_details[0]['content_news_summary_color'] }}; font-size: {{ $get_client_details[0]['content_news_summary_font_size'] }};">
                                        {{ $news['summary'] }}
                                    </p>
                                    <p>Date: {{ date('d-m-Y', strtotime($news['create_at'])) }} ,
                                        Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] != '' ? $news['Journalist'] : $news['Agency'] }} </span>  , 
                                        Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, Page No:<span style="color:blue;"> {{ $news['page_no'] }}</span>  
                                    </p>
                                    <hr>
                                </div>

                                <div id="clientnewsContentEdit-{{ $news['news_details_id'] }}" style="display: none;">
                                    <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                                        <div class="headline" style="width: 500px;">
                                            <h6>Headline:</h6>
                                            <textarea name="" id="update_headline_{{ $news['news_details_id'] }}" class="form-control">{{ $news['head_line'] }}</textarea>
                                        </div>
                                        
                                        <h6 class="showEdit2">
                                            <div style="d-flex">
                                                <a class="btn border" onclick="updateNewsContent('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')"> Update News</a> 
                                            </div>
                                        </h6>
                                    </div>
                                
                                    <h6>Summary:</h6>
                                    <textarea name="" id="update_summary_{{ $news['news_details_id'] }}" class="form-control">{{ $news['summary'] }}</textarea>
                                    <p>Date: {{ date('d-m-Y', strtotime($news['create_at'])) }} ,
                                        Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] != '' ? $news['Journalist'] : $news['Agency'] }} </span> , 
                                        Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, Page No:<span style="color:blue;"> {{ $news['page_no'] }}</span>  
                                    </p>
                                    <hr>
                                </div>
                                @endforeach
                            @endif
                        @endforeach
                    @else
                        <p style="text-align: center; padding: 20px; color: #666;">No news available for this company.</p>
                    @endif
                </div>
                <!-- This is for competitors -->
                <div class="body-content" style="padding:10px 15px 0px 15px;">
                    <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;">Competition</h4>
                </div>

                @foreach ($get_client_details[0]['compititors_data'] as $compititor)
                    <div class="body-content" id="competitordiv" style="padding:10px 15px 0px 15px;">
                        <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;">{{ $compititor['Competitor_name'] }}</h4>

                        @if (!empty($compititor['news']) && is_array($compititor['news']) && count($compititor['news']) > 0)
                            @foreach ($compititor['news'] as $news)
                            <div id="competitornewsContent-{{ $news['news_details_id'] }}-{{ $compititor['competitor_id'] }}" style="display: block;">
                                <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                                    <h5>
                                        <a href="{{ url('news-article/'.$news['news_details_id']) }}" style="color: {{ $get_client_details[0]['content_headline_color'] }}; font-size: {{ $get_client_details[0]['content_headline_font_size'] }}; font-family: {{ $get_client_details[0]['content_headline_font'] }}">
                                            {{ $news['head_line'] }}
                                        </a>
                                    </h5>
                                    <h6 class="showEdit">
                                        <div style="d-flex">
                                            <a onclick="toggleNewsContent2('{{ $news['news_details_id'] }}', '{{ $compititor['competitor_id'] }}')"> Edit News</a> |
                                            <a onclick="hideNews('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')"> Hide</a> | 
                                            <a style="color:red;" onclick="deleteNews('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')">Delete</a> 
                                        </div>
                                    </h6>
                                </div> 
                                <h6>Summary:</h6>
                                <p style="color: {{ $get_client_details[0]['content_news_summary_color'] }}; font-size: {{ $get_client_details[0]['content_news_summary_font_size'] }};">
                                    {{ $news['summary'] }}
                                </p>
                                <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }} ,
                                    Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] ? $news['Journalist'] : $news['Agency'] }}</span> , 
                                    Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, Page No:<span style="color:blue;"> {{ $news['page_no'] }}</span> 
                                </p>                 
                                <hr>
                            </div>  

                            <div id="competitornewsContentEdit-{{ $news['news_details_id'] }}-{{ $compititor['competitor_id'] }}" style="display: none;">
                                <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                                    <div class="headline" style="width: 500px;">
                                        <h6>Headline:</h6>
                                        <textarea name="" id="com_update_headline_{{ $news['news_details_id'] }}" class="form-control">{{ $news['head_line'] }}</textarea>
                                    </div>
                                    
                                    <h6 class="showEdit2">
                                        <div style="d-flex">
                                            <a class="btn border" onclick="updateNewsContent2('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')"> Update News</a> 
                                        </div>
                                    </h6>
                                </div>
                            
                                <h6>Summary:</h6>
                                <textarea name="" id="com_update_summary_{{ $news['news_details_id'] }}" class="form-control">{{ $news['summary'] }}</textarea>
                                <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }} ,
                                    Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] ? $news['Journalist'] : $news['Agency'] }}</span>  , 
                                    Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, Page No:<span style="color:blue;"> {{ $news['page_no'] }}</span> 
                                </p>
                                <hr>
                            </div>
                            @endforeach
                        @else
                            <p style="text-align: center; padding: 20px; color: #666;">No news available for this competitor.</p>
                        @endif
                    </div>
                @endforeach

                <div class="body-content" style="padding:10px 15px 0px 15px;">
                    <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;"> Industry</h4>
                </div>
                @foreach ($get_client_details[0]['industry_data'] as $Industry)
                    <div class="body-content" id="industrydiv" style="padding:10px 15px 0px 15px;">
                        <h4 style="background-color: #cfbbbb; color: #ffffff; padding:4px;"> {{ $Industry['Industry_name'] }}</h4>

                        @if (!empty($Industry['news']) && is_array($Industry['news']) && count($Industry['news']) > 0)
                            @foreach ($Industry['news'] as $news)
                            <div id="IndustrynewsContent-{{ $news['news_details_id'] }}-{{ $Industry['Industry_id'] }}" style="display: block;">
                                <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                                    <h5>
                                        <a href="{{ url('news-article/'.$news['news_details_id']) }}" style="color: {{ $get_client_details[0]['content_headline_color'] }};font-size: {{ $get_client_details[0]['content_headline_font_size'] }};font-family: {{ $get_client_details[0]['content_headline_font'] }}">  
                                            {{ $news['head_line'] }} 
                                        </a>
                                    </h5>
                                    <h6 class="showEdit">
                                        <div style="d-flex">
                                            <a onclick="toggleNewsContent3('{{ $news['news_details_id'] }}', '{{ $Industry['Industry_id'] }}')"> Edit News</a> |
                                            <a onclick="hideNews('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')"> Hide</a> | 
                                            <a style="color:red;" onclick="deleteNews('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')">Delete</a> 
                                        </div>
                                    </h6>
                                </div> 
                                <h6>Summary:</h6>
                                <p style="color: {{ $get_client_details[0]['content_news_summary_color'] }};font-size: {{ $get_client_details[0]['content_news_summary_font_size'] }};">
                                    {{ $news['summary'] }}
                                </p>
                                <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }} ,
                                    Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] }}</span>  , 
                                    Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, Page No:<span style="color:blue;"> {{ $news['page_no'] }}</span> 
                                </p>                 
                                <hr>
                            </div>  
                            <div id="IndustrynewsContentEdit-{{ $news['news_details_id'] }}-{{ $Industry['Industry_id'] }}" style="display: none;">
                                <div style="display:flex; justify-content: space-between; padding:0px 10px 0px 0px;">
                                    <div class="headline" style="width: 500px;">
                                        <h6>Headline:</h6>
                                        <textarea name="" id="industry_update_headline_{{ $news['news_details_id'] }}" class="form-control">{{ $news['head_line'] }}</textarea>
                                    </div>
                                    <h6 class="showEdit2">
                                        <div style="d-flex">
                                            <a class="btn border" onclick="updateNewsContent3('{{ $news['news_details_id'] }}', '{{ $details['client_id'] }}')"> Update News</a> 
                                        </div>
                                    </h6>
                                </div>
                                <h6>Summary:</h6>
                                <textarea name="" id="industry_update_summary_{{ $news['news_details_id'] }}" class="form-control">{{ $news['summary'] }}</textarea>
                                <p>Date: {{ \Carbon\Carbon::parse($news['create_at'])->format('d-m-Y') }} ,
                                    Publication :<span style="color:blue;"> {{ $news['MediaOutlet'] }}</span>, Journalist / Agency :<span style="color:blue;"> {{ $news['Journalist'] }}</span>  , 
                                    Edition : <span style="color:blue;"> {{ $news['Edition'] }} </span>,  Supplement : <span style="color:blue;"> {{ $news['Supplement'] }} </span>, Page No:<span style="color:blue;"> {{ $news['page_no'] }}</span> 
                                </p>
                                <hr>
                            </div>
                            @endforeach
                        @else
                            <p style="text-align: center; padding: 20px; color: #666;">No news available for this industry.</p>
                        @endif
                    </div>
                @endforeach
                <div class="col-md-12 news-footer" style="background-color: {{ $get_client_details[0]['footer_background_color'] }};">
                <div class="d-flex justify-content-between">
                    <div class="logo" style="text-align:left;">
                        @if ($get_client_details[0]['footer_logo_position'] == 'Left')
                            <img src="{{ $get_client_details[0]['footer_logo_url'] }}" alt="logo" style="width:100px; padding:5px;"><br>
                        @endif
                    </div>
                    <div class="footer" style="text-align:center;">
                        @if ($get_client_details[0]['footer_logo_position'] == 'Center')
                            <img src="{{ $get_client_details[0]['footer_logo_url'] }}" alt="logo" style="width:100px; padding:5px;"><br>
                        @endif
                    </div>
                    <div class="footer" style="text-align:end;">
                        @if ($get_client_details[0]['footer_logo_position'] == 'Right')
                            <img src="{{ $get_client_details[0]['footer_logo_url'] }}" alt="logo" style="width:100px; padding:5px;"><br>
                        @endif
                    </div>
                </div>
                <p style="font-size:{{ $get_client_details[0]['footer_title_font_size'] }}px; color:{{ $get_client_details[0]['footer_title_font_color'] }};text-align: center">{{ $get_client_details[0]['footer_title_name'] }}</p>
                <p><span style="color:red; font-weight:bold;">This is an auto generated email – please do not reply to this email id</span></p>
            </div>
</div>   
<div class="modal fade" id="getEmailsModal" tabindex="-1" role="dialog" aria-labelledby="getEmailsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getEmailsLabel">Emails</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="sendEmailForm" action="{{ route('sendEmailWithTemplate') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <!-- Dynamically filled checkboxes will be added here -->
                    </div>
                    <div class="text-right pt-2">
                        <button type="button" id="sendEmailButton" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function scrollToTarget(targetId) {
        // Get the target element by ID
        const targetElement = document.getElementById(targetId);
        
        // Scroll to the target element with smooth behavior
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    function scrollToTarget2(targetId) {
        // Get the target element by ID
        const targetElement = document.getElementById(targetId);
        
        // Scroll to the target element with smooth behavior
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    function scrollToTarget3(targetId) {
        // Get the target element by ID
        const targetElement = document.getElementById(targetId);
        
        // Scroll to the target element with smooth behavior
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
<script>
function getEmail(client_id) 
{
      console.log("client_id:", client_id);
      $.ajax({
        type: "POST",
        url: "{{ route('getEmail') }}",
        dataType: 'json',
        data: {
          client_id: client_id,
          _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          console.log("Response:", response);
          // Clear previous email checkboxes
          $('#getEmailsModal .modal-body .form-group').empty();
          var i = 0;
          // Append hidden fields for client_id and client_ids outside the loop
          $('#getEmailsModal .modal-body .form-group').append(
            '<input type="hidden" name="client_id" value="' + response.c_id + '">' +
            '<input type="hidden" name="client_ids" value="' + response.client_ids.join(",") + '">' 
          );

          // Handle the response data
          if (response && response.emails && response.emails.length > 0) {
            response.emails.forEach(function(email) {
              console.log("Email:", email.client_email);
              i++;
              console.log("i value:", i);

              $('#getEmailsModal .modal-body .form-group').append(
                '<input type="hidden" name="index" value="' + i + '">' +
                '<div class="form-check">' +
                  '<label class="form-check-label justify-content-between">' +
                    '<input type="checkbox" name="clientMails' + i + '[]" class="form-check-input" value="' + email.client_email + '">' + email.client_email +
                  '</label>' +
                '</div>'
              );
            });
          } else {
            console.log("No emails found for this client.");
            $('#getEmailsModal .modal-body .form-group').append('<p>No emails found for this client.</p>');
          }

          // Show the modal
          $('#getEmailsModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error("AJAX error:", status, error);
        }
      });
    }
    $(document).ready(function() {
        $('#sendEmailButton').click(function() {
            var formData = $('#sendEmailForm').serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('sendEmailWithTemplate') }}",
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                    console.log('Client Details:', response.get_client_details);
                    location.reload(); // Optionally reload the page to show the success message
                } else {
                    alert("Error: " + response.message);
                }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });

</script>
<script>  

function deleteNews(news_details_id, client_id) {
    console.log("news id :", news_details_id);
    console.log("client_id :", client_id);
    
    $.ajax({
        type: "POST",
        url: "{{ route('deleteNews') }}",
        dataType: 'json',
        data: {
            news_details_id: news_details_id,
            client_id: client_id,
            type: 'delete',
            _token: '{{ csrf_token() }}' // Include CSRF token
        },
        success: function(response) {
            if (response.status === 'success') {
                // alert(response.message);
                location.reload(); // Uncomment if you want to reload the page
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}

    function hideNews(news_details_id, client_id)
    {

        console.log("news id :", news_details_id);
        console.log("client_id :", client_id);
    
        $.ajax({
            type: "POST",
            url: "{{ route('deleteNews') }}",
            dataType: 'json',
            data: {
                news_details_id: news_details_id,
                client_id: client_id,
                type: 'hide',
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
                if (response.status === 'success') {
                    // alert(response.message);
                    location.reload(); // Uncomment if you want to reload the page
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    }

</script>
<script>
    document.getElementById('generatePDF').addEventListener('click', function() {
    var element = document.getElementById('content');
    var hideSection = document.getElementById('hideThis');
    
    // Hide the section before generating the PDF
    hideSection.style.display = 'none';
    
    var opt = {
        margin: [-0.27, 0, 0, 0], // No margins
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
    };
    
    html2pdf().from(element).set(opt).save().then(function() {
        // Restore the section after generating the PDF
        hideSection.style.display = 'block';
    });
});


</script>
<script>
    function editFuncation()
    {
        $('.showEdit').toggle();
    }
   
    function toggleNewsContent(newsDetailsId) 
    {
        console.log(newsDetailsId);
        var content = document.getElementById('clientnewsContent-' + newsDetailsId);
        var contentEdit = document.getElementById('clientnewsContentEdit-' + newsDetailsId);
        
        if (content.style.display === "none") {
            content.style.display = "block";
            contentEdit.style.display = "none";
        } else {
            content.style.display = "none";
            contentEdit.style.display = "block";
        }
    }

function toggleNewsContent2(newsDetailsId, competitorId) 
{
    var content = document.getElementById('competitornewsContent-' + newsDetailsId + '-' + competitorId);
    var contentEdit = document.getElementById('competitornewsContentEdit-' + newsDetailsId + '-' + competitorId);
    
    if (content.style.display === "none") {
        content.style.display = "block";
        contentEdit.style.display = "none";
    } else {
        content.style.display = "none";
        contentEdit.style.display = "block";
    }
}

function toggleNewsContent3(newsDetailsId, industryId) {
    var content = document.getElementById('IndustrynewsContent-' + newsDetailsId + '-' + industryId);
    var contentEdit = document.getElementById('IndustrynewsContentEdit-' + newsDetailsId + '-' + industryId);
    
    if (content.style.display === "none") {
        content.style.display = "block";
        contentEdit.style.display = "none";
    } else {
        content.style.display = "none";
        contentEdit.style.display = "block";
    }
}

function updateNewsContent(news_details_id, client_id) {
    var headline = document.getElementById('update_headline_' + news_details_id).value;
    var summary = document.getElementById('update_summary_' + news_details_id).value;

    // Debugging: Output the retrieved values to console
    console.log("news_details_id :", news_details_id)
    console.log("Headline:", headline);
    console.log("Summary:", summary);

    // Get the CSRF token from Laravel
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Send the extracted data through AJAX
    $.ajax({
        type: "POST",
        url: "{{ route('updateNews') }}", // Ensure this route is defined in Laravel
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        dataType: 'json',
        data: {
            news_details_id: news_details_id,
            client_id: client_id,
            headline: headline,
            summary: summary
        },
        success: function(response) {
            // Handle success response
            console.log("Update successful", response);
            location.reload(); // Reload the page to see the changes
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error("Update failed", status, error);
        }
    });
}

function updateNewsContent2(news_details_id, client_id) 
{
    console.log("Function called");

    var headline = document.getElementById('com_update_headline_' + news_details_id).value;
    var summary = document.getElementById('com_update_summary_' + news_details_id).value;

    // Debugging: Output the retrieved values to console
    console.log("Headline:", headline);
    console.log("Summary:", summary);
    console.log("News Details ID:", news_details_id);

    // Fetch client details from PHP
    var get_client_details = <?php echo json_encode($get_client_details); ?>;
    console.log("get_client_details data", get_client_details);

    // Find the client with the given client_id
    var client = get_client_details.find(client => client.client_id == client_id);

    if (client) {
        var clientNews = client.client_news;
        var competitorsData = client.compititors_data;
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var found = false;

        // Check in client_news
        if (clientNews) {
            console.log("Client news:", clientNews);
            var news = clientNews.find(news => news.news_details_id == news_details_id);

            if (news) {
                found = true;
                updateNews(news_details_id, client_id, headline, summary, csrfToken);
            }
        }

        // Check in competitors_data if not found in client_news
        if (!found && competitorsData) {
            console.log("Competitors data:", competitorsData);
            for (var i = 0; i < competitorsData.length; i++) {
                var competitor = competitorsData[i];
                var news = competitor.news.find(news => news.news_details_id == news_details_id);

                if (news) {
                    found = true;
                    updateNews(news_details_id, client_id, headline, summary, csrfToken);
                    break;
                }
            }
        }

        if (!found) {
            console.log("No news found with news_details_id: " + news_details_id + " in both clientNews and compititors_data.");
        }
    } else {
        console.log("No client found with client_id:", client_id);
    }

    function updateNews(news_details_id, client_id, headline, summary, csrfToken) {
        $.ajax({
            type: "POST",
            url: "{{ route('updateNewsofCompIndu') }}",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'json',
            data: {
                news_details_id: news_details_id,
                client_id: client_id,
                headline: headline,
                summary: summary
            },
            success: function(response) {
                // Handle success response
                console.log("Update successful", response);
                // location.reload(); // Reload the page to see the changes
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error("Update failed", status, error);
            }
        });
    }
}

function updateNewsContent3(news_details_id, client_id) {
    var headline = document.getElementById('industry_update_headline_' + news_details_id).value;
    var summary = document.getElementById('industry_update_summary_' + news_details_id).value;

    // Debugging: Output the retrieved values to console
    console.log("Headline:", headline);
    console.log("Summary:", summary);
    var get_client_details = <?php echo json_encode($get_client_details); ?>;
    console.log("get_client_details data", get_client_details);

    // Loop through the get_client_details to find the client with the given client_id
    var clientNews = null;
    for (var i = 0; i < get_client_details.length; i++) {
        if (get_client_details[i].client_id == client_id) {
            clientNews = get_client_details[i].client_news;
            break;
        }
    }

    if (clientNews) {
        // Loop through the clientNews to find the news with the given news_details_id
        for (var j = 0; j < clientNews.length; j++) {
            if (clientNews[j].news_details_id == news_details_id) {
                // Extract the specific data you need
                var media_type_id = clientNews[j].media_type_id;
                var publication_id = clientNews[j].publication_id;
                var edition_id = clientNews[j].edition_id;
                var supplement_id = clientNews[j].supplement_id;
                var journalist_id = clientNews[j].journalist_id;
                var agencies_id = clientNews[j].agencies_id;
                var author = clientNews[j].author;
                var news_position = clientNews[j].news_position;
                var news_city_id = clientNews[j].news_city_id;
                var category_id = clientNews[j].category_id;
                var is_send = clientNews[j].is_send;
                var keywords = clientNews[j].keywords;
                var page_count = clientNews[j].page_count;

                console.log("News media_type_id:", media_type_id);
                console.log("News publication_id:", publication_id);

                // Send the extracted data through AJAX
                $.ajax({
                    type: "POST",
                    url: "",
                    dataType: 'html',
                    data: {
                        news_details_id: news_details_id,
                        client_id: client_id,
                        headline: headline,
                        summary: summary,
                        media_type_id: media_type_id,
                        publication_id: publication_id,
                        edition_id: edition_id,
                        supplement_id: supplement_id,
                        journalist_id: journalist_id,
                        agencies_id: agencies_id,
                        author: author,
                        news_position: news_position,
                        news_city_id: news_city_id,
                        category_id: category_id,
                        is_send: is_send,
                        keywords: keywords,
                        page_count: page_count
                    },
                    success: function(response) {
                        // Handle success response
                        console.log("Update successful", response);
                        location.reload(); // Reload the page to see the changes
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.error("Update failed", status, error);
                    }
                });

                break;
            }
        }
    }
}
</script>
@include('common/footer')