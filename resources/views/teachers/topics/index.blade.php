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

    <div class="row" align="right">
        <a href="{{asset('teacher/topics/create')}}" class="btn btn-round btn-sm btn-primary">
            THÊM KHÓA LUẬN <i class="fa fa-plus"></i>
        </a>
    </div>
    <br/>
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading" style="background-color: #1ca59e; color: white" align="center">KHÓA LUẬN ĐANG QUẢN LÝ</div>
            <div class="panel-body">
                @foreach($my_topics as $topic)
                    <div class="col-md-4 col-sm-6">
                        @include('widget.topics.topic',['topic'=>$topic])
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading" style="background-color: #1ca59e; color: white" align="center">KHÓA LUẬN ĐỒNG THAM GIA</div>
            <div class="panel-body">
                @foreach($assist_topics as $topic)
                    <div class="col-md-4 col-sm-6">
                        @include('widget.topics.topic',['topic'=>$topic])
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@stop

@section('page-script')
    <script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    @include('teachers.topics.js-teacher-topics')
@stop