<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Đăng ký tài khoản</title>

    <!-- Bootstrap core CSS -->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css"/>

    <link rel="stylesheet" type="text/css" href="js/bootstrap-datepicker/css/datepicker.css" />
    
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css?1" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="lock-screen">
    <div class="collapse navbar-collapse" id="app-navbar-collapse">
        <!-- Left Side Of Navbar -->
        <ul class="nav navbar-nav">
            &nbsp;
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Đăng nhập</a></li>
                <li><a href="{{ url('/register') }}">Đăng ký</a></li>
            @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->getFullName() }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
    <div class="lock-wrapper">

        <div class="col-md-12" style="margin-top: -100px !important">
            <div class="panel panel-success">
                <div class="panel-heading" align="center">Đăng ký</div>
                <div class="panel-body">
                    <!-- {!! Form::open(array('url' => 'register','files'=>'true')) !!} -->
                    <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{ url('/register') }}" files="true">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 160px !important" align="center">
                            
                                <img src="{{asset('images/NOIMAGE.jpg')}}" alt="" id="img">
                                <input type="file" name="avatar" onchange="file_change(this,'img')" style="display: none" id="avatar">
                            </div>
                            <div class="col-md-12" align="center">
                                <button type="button" class="btn btn-white btn-sm" onclick="document.getElementById('avatar').click()">
                                    <i class="fa fa-pencil"></i> Chọn ảnh
                                </button>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Tên tài khoản</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Địa chỉ Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Mật khẩu</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Nhập lại mật khẩu</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Ngày sinh</label>
                            <div class="col-md-6">
                                <!-- <input type="text" class="form-control" id="datepicker" name="dob" value="01-01-1980"> -->
                                <div class="input-group date form_datetime">
                                    <input type="text" class="form-control" readonly="" size="16" value="01-01-1980" name="dob">
                                            <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary date-set"><i class="fa fa-calendar"></i></button>
                                            </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Giới tính</label>
                            <div class="col-md-3">
                                <input type="radio" name="gender" value="0" checked>
                                <label>Nam </label>
                            </div>
                            <div class="col-md-3">
                                <input type="radio" name="gender" value="1">
                                <label>Nữ </label>
                            </div>
                        </div>

                      

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="fullName" class="col-md-4 control-label">Họ và tên</label>

                            <div class="col-md-6">
                                <input id="fullName" type="text" class="form-control" name="fullName" value="{{ old('fullName') }}">

                                @if ($errors->has('fullName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fullName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Số điện thoại</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Địa chỉ</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="address">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Đăng ký
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- {!! Form::close() !!} -->
                </div>
            </div>
        </div>

    </div>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script src="js/jquery.js"></script>
<script src="js/jquery-1.10.2.min.js"></script>
<script src="bs3/js/bootstrap.min.js"></script>
<script src="js/jquery-ui-1.9.2.custom.min.js"></script>

<script type="text/javascript" src="js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

@include('layouts.general-script')
</body>
</html>
