<div class="row">
    <div class="col-md-12" style="margin-top: 30px !important" align="center">
        <img src="{{asset($user->avatar)}}" alt="" id="avatar_edit_base64" class="img-circle" width="200px">
        <input type="file" name="avatar" onchange="file_change(this,'avatar_edit_base64')" style="display: none" id="avatar_edit">
    </div>
    <div class="col-md-12" align="center" style="margin-top: -30px;margin-left: 60px">
        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('avatar_edit').click()">
            <i class="fa fa-pencil"></i> Chọn ảnh
        </button>
    </div>
</div>
<br/>

<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
    <label for="username" class="col-md-4 control-label">Tên tài khoản</label>

    <div class="col-md-6">
        <input type="text" class="form-control" value="{{$user->username}}" disabled="disabled">
    </div>
</div>

<div class="form-group">
    <label for="email" class="col-md-4 control-label">Địa chỉ Email</label>
    <div class="col-md-6">
        <input type="email" class="form-control" value="{{$user->email}}" disabled="disabled">
    </div>
</div>

<div class="form-group">
    <label for="password" class="col-md-4 control-label">Mật khẩu mới</label>
    <div class="col-md-6">
        <input id="password-edit" type="password" class="form-control" name="password">
    </div>
</div>

<div class="form-group">
    <label for="password-confirm" class="col-md-4 control-label">Nhập lại mật khẩu</label>
    <div class="col-md-6">
        <input id="password-confirm-edit" type="password" class="form-control" name="password_confirmation">
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">Ngày sinh</label>
    <div class="col-md-6">
        <!-- <input type="text" class="form-control" id="datepicker" name="dob" value="01-01-1980"> -->
        <div class="input-group date form_datetime">
            <input type="text" class="form-control" readonly="" size="16" value="{{Carbon\Carbon::parse($user->dob)->format('d-m-Y')}}" name="dob" id="dob-edit">
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
        <input type="radio" name="gender_edit" value="0" checked>
        <label>Nam </label>
    </div>
    <div class="col-md-3">
        <input type="radio" name="gender_edit" value="1">
        <label>Nữ </label>
    </div>
    @else
    <div class="col-md-3">
        <input type="radio" name="gender_edit" value="0">
        <label>Nam </label>
    </div>
    <div class="col-md-3">
        <input type="radio" name="gender_edit" value="1" checked>
        <label>Nữ </label>
    </div>
    @endif
</div>

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="fullName" class="col-md-4 control-label">Họ và tên</label>

    <div class="col-md-6">
        <input id="fullName-edit" type="text" class="form-control" name="fullName" value="{{$user->getFullName()}}">
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
        <input type="text" class="form-control" name="address" id="address-edit" value="{{$user->address}}">
    </div>
</div>
<script type="text/javascript">
    $(".form_datetime").datepicker({
        showAnim: "drop",
        format: "dd-mm-yyyy",
        yearRange: "1930:2020",
        changeMonth: true,
        changeYear: true,
    });
</script>