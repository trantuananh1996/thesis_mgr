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
    <br/>

    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading" style="background-color: #1ca59e; color: white" align="center">KHÓA LUẬN CỦA TÔI</div>
            <div class="panel-body">
                @if(!is_null($student->topic->register_topic))
                    <div class="row">
                        @include('widget.topics.topic',['topic'=>$student->topic->register_topic,'student'=>$student,'mark'=>1])
                        <hr/>
                    </div>
                @endif

                @if(!is_null($student->topic->current_topic))
                    <div class="row">
                        @include('widget.topics.topic',['topic'=>$student->topic->current_topic,'student'=>$student,'mark'=>1])
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel panel-success">
            <div class="panel-heading" style="background-color: #1ca59e; color: white" align="center">
                @if($unit_name != '')
                    KHÓA LUẬN TRONG {{$unit_name}} 
                @else
                    KHÓA LUẬN TRONG KHOA
                @endif
            </div>
            <div class="panel-body">
                @foreach($topics as $topic)
                    <div class="col-md-6">
                        @include('widget.topics.topic',['topic'=>$topic,'student'=>$student])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('page-script')
    <script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    @include('students.topics.js-student-topics')
@stop