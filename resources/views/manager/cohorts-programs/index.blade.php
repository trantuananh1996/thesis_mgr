@extends ('layouts.master')

@section('head')
    <title>Niên khóa - Chương trình đào tạo</title>
    <style type="text/css">.jqstooltip { position: absolute;left: 30px;top: 0px;display: block;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;border: 0px solid white;border-radius: 3px;-webkit-border-radius: 3px;z-index: 10000;}.jqsfield { color: white;padding: 5px 5px 5px 5px;font: 10px arial, san serif;text-align: left;}
    </style>
    
@stop

@section('top-menu-left')
    <h4>
        NIÊN KHÓA - CHƯƠNG TRÌNH ĐÀO TẠO
    </h4>        
@endsection

@section('content')
<div class="panel row col-md-12">
    <header class="panel-heading tab-bg-dark-navy-blue " style="border-spacing: 10px">
        <ul class="nav nav-tabs">
            @foreach($cohorts as $index=>$cohort)
                @if($index == 0)
                <li class="active">
                @else
                <li>
                @endif
                    <a data-toggle="tab" href="#cohort-tab{{$cohort->id}}">{{$cohort->name}}</a>
                </li>
            @endforeach
            <li class="pull-right">
                <a href="{{asset('/cohorts-programs/config')}}" class="btn btn-sm btn-info pull-right" style="color:white">
                    THIẾT LẬP <i class="fa fa-cog"></i>
                </a>          
            </li>
        </ul>
    </header>
    <div class="panel-body">
        <div class="tab-content">
            @foreach($cohorts as $index=>$cohort)
            @if($index == 0)
                <div id="cohort-tab{{$cohort->id}}" class="tab-pane active">
            @else
                <div id="cohort-tab{{$cohort->id}}" class="tab-pane">
            @endif
            <!-- CONTENT OF COHORT -->
                <div class="row">
                    <select id="select-programs-cohort{{$cohort->id}}" class="form-control" style="width: 250px; color: #636363" 
                    onchange="show_cohort_students({{$cohort->id}},this.value,'students-cohort{{$cohort->id}}')"
                    onclick="show_cohort_students({{$cohort->id}},this.value,'students-cohort{{$cohort->id}}')">
                        @foreach($cohort->programs as $index=>$program)
                        @if($index == 0)
                        <option value="{{$program->id}}" selected>
                        @else
                        <option value="{{$program->id}}">
                        @endif
                            {{$program->name}}
                        </option>
                        @endforeach
                    </select>
                    <div class="row col-md-12" id="students-cohort{{$cohort->id}}">
                    </div>
                </div>
            <!-- END CONTENT -->
            </div>
            @endforeach
        </div>
    </div>
</div>

@stop

@section('page-script')

    <script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>
    @include('manager.cohorts-programs.cohort-students.script-cohort-students')
@stop