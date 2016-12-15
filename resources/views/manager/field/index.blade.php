@extends('layouts.master')
@section('head')
    <link href="{{asset('css/dataTable.css')}}" rel="stylesheet"/>

@endsection
@section('top-menu-left')
    <h4>
        {!! Breadcrumbs::render('field') !!}
    </h4>
@endsection

@section('sidebar-menu')
    @include('partials.manager-sidebar')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    DANH SÁCH CÁC LĨNH VỰC
                    <div class="pull-right" style="text-transform: none;">
                        <a href="{{route('field.create')}}" class="btn btn-round btn-primary">
                            <i class="fa fa-plus fa-fw"></i>Thêm lĩnh vực
                        </a>
                    </div>
                </header>
                <div class="panel-body">

                    @if(count($fields) == 0)
                        <div class="alert alert-info">
                            Hiện tại chưa có lĩnh vực nào
                        </div>
                    @else
                        <div class="adv-table">
                            <div class="modal fade" id="teachers-fields" tabindex="-1" teacher="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
                                <div class="modal-content" id="teacher-field-panel" style="width:75%; margin:auto; margin-top:20px;">

                                </div>
                            </div>
                            <script type="text/javascript">
                                function showTeacherConnectField(field_id){
                                    $.ajax({
                                        url      : 'field/show-teacher-connect-field',
                                        type     : "POST",
                                        data     : {
                                            field_id: field_id
                                        },
                                        success  : function(data){
                                            $('#teacher-field-panel').html(data);
                                        },
                                        error:function(){
                                            alert("Không lấy được thông tin này!","Lỗi",'error');
                                        }
                                    });
                                    return false;
                                }
                            </script>
                            <table class="table table-bordered" id="dynamic-table">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã lĩnh vực</th>
                                    <th>Tên lĩnh vực</th>
                                    <th>Đơn vị</th>
                                    <th>Mô tả</th>
                                    <th style="width: 30%">Tùy chọn</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fields as $index=>$field)
                                    @include('manager.field._field')
                                @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
@section('page-script')
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script>
        $(document).ready(function () {
            initDataTable($('#dynamic-table'));
        });
    </script>
@endsection