@extends ('layouts.master')

@section('head')
    <title>Thông tin đợt đăng ký</title>
    <link rel="stylesheet" href="{{URL::asset('table/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
@stop

@section('top-menu-left')
    <h4>
        Thông tin đợt đăng ký {{$term->name}}
    </h4>
    @endsection
    @section('content')
            <!-- FORM UPLOADED studentS -->
    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Tải tệp tin thông tin sinh viên đủ điều kiện</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(array('route'=>'terms.upload','id'=>'form-upload','files' => true,'class'=>'form-horizontal','method'=>'post')) !!}
                    <div class="form-group">
                        <label class="control-label col-sm-3" style="text-align: left;">Chọn tệp tin:</label>
                        <div class="col-sm-5">
                            <div class="row">
                                <input type="hidden" name="term_id" value="{{$term->id}}"/>
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
                            <button type="submit" class="btn btn-primary">Tải danh sách sinh viên</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- END FORM -->
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-4">
                <button class="btn btn-primary" id="sendEmail">
                    <i class="fa fa-bullhorn"></i> Gửi thông báo
                </button>
                <button class="btn  btn-info" title="Xem" data-toggle="modal" data-target="#students-fields" onclick="showStudentConnectTerm({{$term->id}})">
                    <i class="fa fa-users"></i> Cập nhật danh sách sinh viên
                </button>
            </div>



            <div class="col-md-8 pull-right" style="text-align: right">
                <button class="btn btn-success" style="margin-left: 5px;margin-right: 5px" href="#"
                        id="down-template">
                    <i class="fa fa-file fa-fw"></i> Tải mẫu nhập sinh viên đủ điều kiện
                </button>
                <button class="btn btn-success" data-toggle="modal" style="margin-left: 5px;margin-right: 5px"
                        data-target="#uploadFile"><i class="fa fa-cloud-upload fa-fw"></i>
                    Tải tệp danh sách sinh viên đủ điều kiện
                </button>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="modal fade" id="students-fields" tabindex="-1" student="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true" align="left">
            <div class="modal-content" id="student-field-panel"
                 style="width:75%; margin:auto; margin-top:20px;">

            </div>
        </div>
        <script type="text/javascript">
            function showStudentConnectTerm(term_id) {
                $.ajax({
                    url: 'show-student-connect-term',
                    type: "POST",
                    data: {
                        term_id: term_id
                    },
                    success: function (data) {
                        $('#student-field-panel').html(data);
                    },
                    error: function () {
                        alert("Không lấy được thông tin này!", "Lỗi", 'error');
                    }
                });

                return false;
            }
        </script>
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    Danh sách sinh viên đủ điều kiện đăng ký
                </header>
                <div class="panel-body" id="student-list-table">
                    @include('manager.terms.student-list')
                </div>
            </section>
        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript">
        $(document).ready(function () {
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

            $('#sendEmail').on('click',function () {
                swal({
                    text: "Xác nhận gửi email đến toàn bộ các sinh viên trong danh sách được đăng ký",
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa fa-check fa-fw"></i> Xác nhận',
                    cancelButtonText: '<i class="fa fa-times fa-fw"></i>Hủy gửi',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function () {
                    $.ajax({
                        url: 'email-to-student',
                        type: "POST",
                        data: {
                            term_id: {{$term->id}}
                        },
                        success: function (data) {
                           if(data == 1){
                               alert('Hệ thống sẽ tự động gửi mail cho các sinh viên','Thành công','success');
                           }
                           else if(data == 2){
                               alert('Không tìm thấy đợt đăng ký','Lỗi','error');
                           }
                           else {
                               alert('Không có sinh viên nào hiên đang có trong danh sách được đăng ký','','info');
                           }
                        },
                        error: function () {
                            alert("Không lấy được thông tin này!", "Lỗi", 'error');
                        }
                    });
                }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        return false;
                    }
                });
            });
        });
    </script>
@endsection