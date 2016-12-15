<div class="modal-content">
	<div class="modal-header" style="background-color: #1ca59e; ">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">CẬP NHẬT THÔNG TIN GIẢNG VIÊN</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<form class="form-horizontal" id="form-edit-teacher" role="form" enctype="multipart/form-data" method="POST" action="{{ url('/register') }}" files="true">
				<div class="col-md-6">
					@include('manager.users.edit',['user'=>$teacher])
				</div>
				<div class="col-md-6">
				</div>
				<div class="col-md-12" align="center">
					<button type="submit" class="btn btn-primary" onclick="update_user({{$teacher->id}},'teachers/update','teacher-row{{$teacher->id}}','editTeacher')">
			            Cập nhật <i class="fa fa-save"></i>
			        </button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		form_validate_edit($('#form-edit-teacher'));
	});
</script>

