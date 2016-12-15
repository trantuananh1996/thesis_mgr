<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href='{{asset("/css/app.css")}}'/>
    <link rel="stylesheet" href='{{asset("/css/sweetalert2.min.css")}}'/>
    <!-- <link rel="stylesheet" href='{{asset("/css/dataTable.css")}}'/> -->
    <link rel="icon" href="{{asset('/images/thesis.ico')}}?v=2" />
    <!-- datepicker -->
    <link rel="stylesheet" href='{{asset("js/bootstrap-datepicker/css/datepicker.css")}}'/>
    <link rel="stylesheet" href="{{URL::asset('css/bootstrapValidator.min.css')}}"/>
    <link href='{{asset("css/bootstrap-reset.css")}}' rel="stylesheet">
    <!--external css-->
    <link href='{{asset("font-awesome/css/font-awesome.css")}}' rel="stylesheet"/>

    @yield('head')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>
        #top_menu h4 {
            margin: 0 auto;
            position: relative;
        }
        .swal2-cancel {
            margin-left: 20px;
        }
        .panel-heading a {
            margin: -20px -10px;
            position: relative;
        }
    </style>
</head>
<body>
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        <!--logo start-->
        <div class="brand">
            <a href="#" class="logo" style="  margin: auto; width: 50%;padding-left: 60px;padding-top: 7px">
                <img src="{{asset('images/logo.png')}}" alt="" width="75px" height="60px">
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>
        <!--logo end-->
        <!-- top menu left start -->
        <div class="nav notify-row" id="top_menu">
            <ul class="nav top-menu">
                @yield('top-menu-left')
            </ul>
        </div>
        <!-- top menu left end -->
        <!-- top menu right start -->
        <div class="top-nav clearfix">

            <ul class="nav pull-right top-menu">
                @if(!Auth::guest())
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
                            <img alt="" src="{{asset(Auth::user()->avatar)}}">
                            <span class="username"> {{Auth::user()->getFullName()}}</span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="{{asset('/profile')}}"><i class=" fa fa-user"></i>Tài khoản</a></li>
                            <li><a href="{{asset('/logout')}}"><i class="fa fa-key"></i> Đăng xuất</a></li>
                        </ul>
                    </li>
                @endif
            <!-- @yield('top-menu-right')
                    <li>
                        <div class="toggle-right-box">
                            <div class="fa fa-bars"></div>
                        </div>
                    </li> -->
            </ul>
        </div>
        <!-- top menu right end -->
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse">
            <!-- sidebar menu start-->
            <div class="leftside-navigation">
                <ul class="sidebar-menu" id="nav-accordion">
                <!-- @yield('sidebar-menu') -->
                    @include('partials.manager-sidebar')
                </ul>
            </div>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            @if (count($errors) > 0)

                <div class="alert alert-block alert-danger fade in col-lg-12">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>

                    @foreach ($errors->all() as $error)
                        <p><i class="fa fa-angle-right fa-fw"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if (session('message'))
                <div class="alert alert-success">
                    <button data-dismiss="alert" class="close close-sm" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    <p class="fa fa-warning"></p> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </section>
    </section>
    <!--main content end-->
    <!--right sidebar start-->
<!-- <div class="right-sidebar">
        <div class="right-stat-bar">
            <ul class="right-side-accordion">
                @yield('sidebar-right')
        </ul>
    </div>
</div> -->
    <!--right sidebar end-->


</section>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<!-- Core JS -->
<script type="text/javascript" src="{{ asset('js/sweetalert2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/autosize.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{URL::asset('js/bootstrap-validator/bootstrapValidator.min.js')}}"></script>

@include('layouts.general-script')
@include('partials.flash')
{{Session::forget('flash_message')}}
{{Session::forget('flash_message_overlay')}}
<!-- End CORE JS -->

@yield('page-script')
@yield('load-html-script')
</body>
</html>