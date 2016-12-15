<div class="modal-content">
	<div class="modal-header" style="background-color: #1ca59e; ">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">TẠO SINH VIÊN</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<form class="form-horizontal" id="form-create-student" role="form" enctype="multipart/form-data" method="POST" files="true">
				<div class="col-md-6">
					@include('manager.users.create',['role_code'=>'SV'])
				</div>
				<div class="col-md-6">
					<select class="form-control" name="cohorts_programs" id="cohorts_programs">
						<option value="0,0" selected>
							Chọn niên khóa - chương trình đào tạo ...
						</option>
						@foreach($cohorts_programs as $cohort)
							@foreach($cohort->programs as $program)
								<option value="{{$cohort->id}},{{$program->id}}">
									{{$cohort->name}} - {{$program->name}}
								</option>
							@endforeach
						@endforeach
					</select>
				</div>
				<div class="col-md-12" align="center">
					<button type="submit" id="btn-submit-create" class="btn btn-primary" onclick="create_user('students/create','student_tables','createStudent')">
			            Tạo <i class="fa fa-plus"></i>
			        </button>
				</div>
			</form>
		</div>
	</div>
</div>