@extends ('layouts.master')

@section('head')
    <title>{{$topic->name}}</title>
    <link rel="stylesheet" href="{{URL::asset('table/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
@stop

@section('content')
    <div class="col-md-12">
        @include('widget.topics.topic-info',compact('topic'))
    </div>
@stop

@section('page-script')
    <script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    @include('manager.topics.js-manager-topics')
@stop