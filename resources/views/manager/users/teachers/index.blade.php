@extends ('layouts.master')

@section('head')
    <title>Quản lý giảng viên</title>
    <style>
        .datepicker {
            z-index: 1151 !important;
        }
    </style>
    <link rel="stylesheet" href="{{URL::asset('table/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
@stop

@section('top-menu-left')
    <h4>QUẢN LÝ GIẢNG VIÊN</h4>
@endsection

@section('content')
    <!-- FORM UPLOADED TEACHERS -->
    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tải tệp tin thông tin giáo viên</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('route'=>'teachers.upload','id'=>'form-upload','files' => true,'class'=>'form-horizontal','method'=>'post')) !!}
                    <div class="form-group">
                        <label class="control-label col-sm-3" style="text-align: left;">Chọn tệp tin:</label>
                        <div class="col-sm-5">
                            <div class="row">
                                <input type="file" name="upload" style="display: none" id="upload">
                                <div class="col-sm-10">
                                    <input type="text" name="file_name" class="form-control">
                                </div>
                                <div class="col-sm-2">
                                    <input type="image" src="{{URL::asset('/images/excel-icon.png')}}"
                                           id="img-button"
                                           onclick="document.getElementById('upload').click()"
                                           style="padding-left: 0;margin-left: 0;"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-10">
                            <button type="submit" class="btn btn-primary">Thêm giảng viên</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- END FORM -->

    <!-- FORM CREATE TEACHERS -->
    <div class="modal fade" id="createTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style="width:75%; margin:auto; margin-top:20px;">
            @include('manager.users.teachers.create',['users'=>$teachers])
        </div>
    </div>
    <!-- END FORM -->

    <!-- FORM EDIT TEACHERS -->
    <div class="modal fade" id="editTeacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" style="width:75%; margin:auto; margin-top:20px;" id="formEditTeacher">

        </div>
    </div>
    <!-- END FORM -->


    <div class="row" style="position: relative">
        @can('users_act')
            <div class="col-md-12">
                <div class="col-md-4">
                    <button class="btn btn-success" data-toggle="modal" data-target="#createTeacher">
                        Tạo mới giảng viên +
                    </button>
                </div>
                <div class="col-md-8 pull-right" style="text-align: right">
                    <button class="btn btn-success" style="margin-left: 5px;margin-right: 5px" href="#"
                            id="down-template">
                        <i class="fa fa-file fa-fw"></i> Tải khung nhập thông tin giảng viên
                    </button>
                    <button class="btn btn-success" data-toggle="modal" style="margin-left: 5px;margin-right: 5px"
                            data-target="#uploadFile"><i class="fa fa-cloud-upload fa-fw"></i>
                        Tải tệp tin thông tin giảng viên
                    </button>
                </div>

            </div>
        @endcan
        <div class="col-md-12">

            <div class="table-responsive">
                <table class="table table-striped" id="teacher_tables">
                    <thead>
                    <tr align="left">
                        <th>STT</th>
                        <th>Hình ảnh
                        </th>
                        <th>
                            <input type="text" class="form-control" size="3" placeholder="Tìm mã"/>
                            <p>Mã GV</p>
                        </th>
                        <th>
                            <input type="text" class="form-control" size="6" placeholder="Tìm tên"/>
                            <p>Họ và tên</p>
                        </th>
                        <th>
                            <input type="text" class="form-control" size="8" placeholder="Tìm email"/>
                            <p>Email</p>
                        </th>
                        <th>
                            <input type="text" class="form-control" size="4" placeholder="Tìm điện thoại"/>
                            <p>Điện thoại</p>
                        </th>
                        <th>
                            <input type="text" class="form-control" size="5" placeholder="Tìm đơn vị"/>
                            <p>Đơn vị</p>
                        </th>
                        @can('users_act')
                            <th>Tùy chọn</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teachers as $teacher)
                        <tr id="teacher-row{{$teacher->id}}">
                            <td></td>
                            <td><img width="50px" src="{{asset($teacher->avatar)}}"></td>
                            <td>{{$teacher->username}}</td>
                            <td>{{$teacher->getFullName()}}</td>
                            <td>{{$teacher->email}}</td>
                            <td>{{$teacher->phone}}</td>
                            <td>Tên đơn vị</td>
                            @can('users_act')
                                <td>
                                    <button class="btn btn-sm btn-primary" id="btn-edit-teacher{{$teacher->id}}"
                                            onclick="showFormEdit({{$teacher->id}},'teachers/edit','formEditTeacher')"
                                            data-toggle="modal" data-target="#editTeacher">
                                        <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top"
                                           title="Sửa"></i>
                                    </button>

                                    <button class="btn btn-sm btn-danger" data-method="delete" style="cursor:pointer;"
                                            id="btn-delete-teacher{{$teacher->id}}"
                                            onclick="confirm_delete_user({{$teacher->id}},'teachers/delete','teacher-row{{$teacher->id}}')">
                                        <i class="fa fa-times" data-toggle="tooltip" data-placement="top"
                                           title="Xóa"> </i>
                                    </button>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if(count($teachers) == 0)
                <div class="alert alert-info" id="alert-no-user" align="center"><h3>CHƯA CÓ GIẢNG VIÊN TRONG HỆ
                        THỐNG</h3></div>
            @endif
        </div>

    </div>
@endsection

@section('page-script')

    @include('manager.users.js-users')
    <script type="text/javascript">
        $(document).ready(function () {
            initDataTable($('#teacher_tables'));
            form_validate_create($('#form-create-teacher'));
            $('#down-template').on('click', function () {
                var url = "http://" + window.location.hostname + '{{$templateUrl}}';

                window.location = url;
            });

            $('input[name="upload"]').change(function () {
                var fileName = $(this).val();
                $('input[name="file_name"]').val(fileName);
            });

            $('#img-button').click(function (e) {
                e.preventDefault();
            });
        });
    </script>
@endsection