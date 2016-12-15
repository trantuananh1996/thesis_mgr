@extends('layouts.master')
@section('head')
@endsection
@section('sidebar-menu')
    @include('partials.manager-sidebar')
@endsection
@section('top-menu-left')
    <h4>
        {!! Breadcrumbs::render('unit') !!}
    </h4>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    DANH SÁCH CÁC ĐƠN VỊ
                    <div class="pull-right" style="text-transform: none;">
                        <a href="{{route('unit.create')}}" class="btn btn-round btn-primary">
                            <i class="fa fa-plus fa-fw"></i>Thêm đơn vị
                        </a>
                    </div>
                </header>
                <div class="panel-body">
                    @if(count($units) == 0)
                        <div class="alert alert-info">
                            Hiện tại chưa có đơn vị nào được tạo
                        </div>
                    @else
                        <div class="adv-table">
                            {{--SHOW TEACHER - UNIT CONNECT MODAL--}}
                            <div class="modal fade" id="teachers-units" tabindex="-1" teacher="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
                                <div class="modal-content" id="teacher-unit-panel" style="width:75%; margin:auto; margin-top:20px;">

                                </div>
                            </div>
                            <script type="text/javascript">
                                function showTeacherConnectUnit(unit_id){
                                    $.ajax({
                                        url      : 'unit/show-teacher-connect-unit',
                                        type     : "POST",
                                        data     : {
                                            unit_id: unit_id
                                        },
                                        success  : function(data){
                                            $('#teacher-unit-panel').html(data);
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
                                    <th>Mã đơn vị</th>
                                    <th>Tên đơn vị</th>
                                    <th>Mô tả</th>
                                    <th>Tùy chọn</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($units as $index=>$unit)
                                    @include('manager.unit._unit',$unit)
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
    {{--<script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>--}}
    {{--<script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>--}}
    <script>
        $(document).ready(function () {
            initDataTable($('#dynamic-table'));
        });
    </script>
@endsection