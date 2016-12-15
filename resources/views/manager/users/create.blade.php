<div class="row">
    <div class="col-md-12" style="margin-bottom: 10px !important" align="center">
        <img src="{{asset('images/NOIMAGE.jpg')}}" alt="" id="avatar_base_64" width="200px">
        <input type="file" name="avatar" onchange="file_change(this,'avatar_base_64')" style="display: none" id="avatar">
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
        <div class="input-group date form_datetime">
            <input type="text" class="form-control" readonly="" size="16" value="01-01-1980" name="dob" id="dob">
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
        <input type="text" class="form-control" name="address" id="address">
    </div>
</div>
<input type="hidden" name="role" value="{{$role_code}}" id="role"/>