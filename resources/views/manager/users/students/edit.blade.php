<div class="modal-content">
	<div class="modal-header" style="background-color: #1ca59e; ">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">CẬP NHẬT THÔNG TIN SINH VIÊN</h4>
	</div>
	<div class="modal-body">
		<div class="row">
			<form class="form-horizontal" id="form-edit-student" role="form" enctype="multipart/form-data" method="POST" action="{{ url('/register') }}" files="true">
				<div class="col-md-6">
					@include('manager.users.edit',['user'=>$student])
				</div>
				<div class="col-md-6">
				</div>
				<div class="col-md-12" align="center">
					<button type="submit" class="btn btn-primary" onclick="update_user({{$student->id}},'students/update','student-row{{$student->id}}','editStudent')">
			            Cập nhật <i class="fa fa-save"></i>
			        </button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		form_validate_edit($('#form-edit-student'));
	});
</script>

