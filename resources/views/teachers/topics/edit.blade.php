@extends ('layouts.master')

@section('head')
    <title>Chỉnh sửa đề tài khóa luận</title>
    <link rel="stylesheet" href="{{URL::asset('table/datatables/media/css/dataTables.bootstrap.min.css')}}"/>

    <link rel="stylesheet" href="{{URL::asset('summernote/summernote.css')}}"/>
    <style type="text/css">
    	.note-group-select-from-files label {
    		margin-left: 10px;
    	}
    	.form-group.note-group-select-from-files{
    		margin-left: 10px;
    	}
    	.form-group.note-group-image-url{
    		margin-left: 10px;
    	}
    	.note-image-url{
    		width: 90%;
    	}
    	.dropdown-menu.dropdown-style{
    		padding-top: 20px;
    	}
    	.dropdown-menu.dropdown-style li{
    		padding-bottom: 40px;
    	}
    </style>
@stop

@section('top-menu-left')
@endsection

@section('content')
    <div class="col-md-8">
        <div class="panel panel-success">
            <div class="panel-heading" style="background-color: #1ca59e; color: white" align="center">
                CHỈNH SỬA ĐỀ TÀI KHÓA LUẬN
                <span class="pull-right">
                    <a title="Quay lại" href="{{asset('teacher/topics')}}">
                        <i class="fa fa-mail-reply"></i>
                    </a>
                </span>
            </div>
            <div class="panel-body">

            	{!! Form::open(array('url' => 'teacher/topics/'.$topic->code.'/update','files'=>'true','class'=>'form-horizontal')) !!}
            	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-2 control-label">TÊN ĐỀ TÀI</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{$topic->name}}" required>
                    </div>
                    <div class="col-md-4">
                    	<select class="form-control" name="field_id" disabled>
                    		<option value="{{$topic->field->id}}" selected>
                                {{$topic->field->name}}
                            </option>
                    	</select>
                    </div>
                </div>

                <textarea id="summernote" name="description" required>{{$topic->description}}</textarea>

                <div class="form-group">
                    <div class="col-md-12" align="right">
                        <button type="submit" class="btn btn-primary">
                            CẬP NHẬT
                        </button>
                    </div>
                </div>

            	{!! Form::close() !!}

            </div>
        </div>
   	</div>
@stop

@section('page-script')
    <script src="{{URL::asset('table/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('table/datatables/media/js/dataTables.bootstrap.min.js')}}"></script>

    <script src="{{URL::asset('summernote/summernote.min.js')}}"></script>

    <script type="text/javascript">
    	$(document).ready(function() {
		  $('#summernote').summernote({
	            height:400
	        });
		});
    </script>
@stop