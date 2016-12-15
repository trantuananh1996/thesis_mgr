<div class="modal-content">
	<div class="modal-header" style="background-color: #1ca59e; ">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">TẠO GIẢNG VIÊN</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<form class="form-horizontal" id="form-create-teacher" role="form" enctype="multipart/form-data" method="POST"  files="true">
				<div class="col-md-6">
					@include('manager.users.create',['role_code'=>'GV'])
				</div>
				<div class="col-md-6">
				</div>
				<div class="col-md-12" align="center">
					<button type="submit" id="btn-submit-create" class="btn btn-primary" onclick="create_user('teachers/create','teacher_tables','createTeacher')">
			            Tạo <i class="fa fa-plus"></i>
			        </button>
				</div>
			</form>
		</div>
	</div>
</div>