@extends ('layouts.master')

@section('head')
    <title>Danh sách đề tài khóa luận</title>
    <link rel="stylesheet" href="{{URL::asset('table/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
@stop

@section('top-menu-left')
    <h4>
        DANH SÁCH ĐỀ TÀI KHÓA LUẬN
    </h4>        
@endsection

@section('content')
    <!-- MODAL CONNECT TUTORS TO TOPIC -->
    <div class="modal fade" id="tutors-topic-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
        <div class="modal-content" id="tutors-topic-panel" style="width:75%; margin:auto; margin-top:20px;">

        </div>
    </div>
    <!-- END MODAL -->

     <!-- MODAL ALLOW OR DENIES STUDENT REGISTER TO TOPIC -->
    <div class="modal fade" id="students-register-topic-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
        <div class="modal-content" id="students-register-topic-panel" style="width:40%; margin:auto; margin-top:20px;">

        </div>
    </div>
    <!-- END MODAL -->

    <!-- MODAL ALLOW OR DENIES STUDENT REGISTER TO TOPIC -->
    <div class="modal fade" id="students-learn-topic-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="left">
        <div class="modal-content" id="students-learn-topic-panel" style="width:40%; margin:auto; margin-top:20px;">

        </div>
    </div>
    <!-- END MODAL -->

    <!-- ALL TOPICS TABLE -->
    <div class="row" style="position: relative">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped" id="topics_tables">
                    <thead>
                        <tr align="left">
                            <th>STT</th>
                            <th>
                                <input type="text" class="form-control" size="25" placeholder="Tìm tên"/>
                                <p>Tên đề tài</p>
                            </th>
                            <th>
                                <input type="text" class="form-control" size="15" placeholder="Tìm lĩnh vực"/>
                                <p>Lĩnh vực</p>
                            </th>
                            <th>
                                <input type="text" class="form-control" size="15" placeholder="Tìm đơn vị"/>
                                <p>Đơn vị</p>
                            </th>
                            <th>
                                <input type="text" class="form-control" size="15" placeholder="Tìm giảng viên"/>
                                <p>Người hướng dẫn</p>
                            </th>
                            <th>
                                <p>Trạng thái</p>
                            </th>
                            <th>
                                <p>Tùy chọn</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($topics as $topic)
                        <tr id="topic-row{{$topic->id}}">
                            <td></td>
                            <td>
                                <a href="{{asset('topics/'.$topic->code.'/info')}}" style="color: #2E64FE;" target="_blank"> 
                                    {{$topic->name}}
                                </a>
                            </td>
                            <td>
                                {{$topic->field->name}}
                            </td>
                            <td>
                                {{$topic->field->unit->name}}
                            </td>
                            <td>
                                {{$topic->author->getFullName()}}
                            </td>
                            <td>
                                @if($topic->is_locked == 1)
                                    <button class="btn btn-danger" id="btn-change-locked{{$topic->id}}" title="Mở đăng ký" index="{{$topic->id}}" >
                                        <i class="fa fa-lock"></i>
                                    </button>
                                @else
                                    <button class="btn btn-info" id="btn-change-locked{{$topic->id}}" title="Khóa đăng ký" index="{{$topic->id}}" >
                                        <i class="fa fa-unlock"></i>
                                    </button>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-danger" id="btn-delete-topic{{$topic->id}}" index="{{$topic->id}}" title="Xóa">
                                    <i class="fa fa-times"></i>
                                </button>     
                            </td>
                    @endforeach
                    </tbody>
                </table>
            </div>

            @if(count($topics) == 0)
                <div class="alert alert-info" id="alert-no-user" align="center"><h3>CHƯA CÓ ĐỀ TÀI KHÓA LUẬN TRONG HỆ THỐNG</h3></div>
            @endif
        </div>

@stop

@section('page-script')
    <script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            initDataTable($('#topics_tables'));
        });
    </script>
    @include('manager.topics.js-manager-topics')
@stop