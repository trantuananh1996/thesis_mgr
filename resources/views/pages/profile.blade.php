@extends('layouts.master')
@section('head')
    <title>Thông tin cá nhân</title>
@endsection
@section('content')
	<div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading" style="background-color: #1ca59e; color: white" align="center">THÔNG TIN TÀI KHOẢN</div>
                <div class="panel-body">
                    {!! Form::open(array('url' => '/profile','files'=>'true','class'=>'form-horizontal')) !!}
                        <div class="row">
                            <div class="col-md-12" style="margin-top: 30px !important" align="center">
                                <img src="{{asset($user->avatar)}}" alt="" id="img" class="img-circle" width="200px">
                                <input type="file" name="avatar" onchange="file_change(this,'img')" style="display: none" id="avatar">
                            </div>
                            <div class="col-md-12" align="center" style="margin-top: -30px;margin-left: 60px">
                                <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('avatar').click()">
                                    <i class="fa fa-pencil"></i> Chọn ảnh
                                </button>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Tên tài khoản</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" value="{{$user->username}}" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Địa chỉ Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" value="{{$user->email}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Mật khẩu cũ</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="old_password">

                                @if ($errors->has('old_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_old') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Mật khẩu mới</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Ngày sinh</label>
                            <div class="col-md-6">
                                <!-- <input type="text" class="form-control" id="datepicker" name="dob" value="01-01-1980"> -->
                                <div class="input-group date form_datetime">
                                    <input type="text" class="form-control" readonly="" size="16" value="{{Carbon\Carbon::parse($user->dob)->format('d-m-Y')}}" name="dob">
                                    <span class="input-group-btn">
                                    	<button type="button" class="btn btn-primary date-set"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Giới tính</label>
                            @if($user->gender == 0)
                            <div class="col-md-3">
                                <input type="radio" name="gender" value="0" checked>
                                <label>Nam </label>
                            </div>
                            <div class="col-md-3">
                                <input type="radio" name="gender" value="1">
                                <label>Nữ </label>
                            </div>
                            @else
                            <div class="col-md-3">
                                <input type="radio" name="gender" value="0">
                                <label>Nam </label>
                            </div>
                            <div class="col-md-3">
                                <input type="radio" name="gender" value="1" checked>
                                <label>Nữ </label>
                            </div>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="fullName" class="col-md-4 control-label">Họ và tên</label>

                            <div class="col-md-6">
                                <input id="fullName" type="text" class="form-control" name="fullName" value="{{$user->getFullName()}}">
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
                                <input type="text" class="form-control" id="phone" name="phone" value="{{$user->phone}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Địa chỉ</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="address" value="{{$user->address}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Cập nhật
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    </div>
@stop