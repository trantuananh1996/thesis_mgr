<div class="panel panel-success">
    <div class="panel-heading" style="background-color: #1ca59e; color: white" align="center">TẠO ĐỢT ĐĂNG KÝ</div>
    <div class="panel-body">
		<form id="form-create-term">
			<div class="form-group">
			    <label for="name" class="col-md-4 control-label">Tên</label>
			    <div class="col-md-8">
			        <input id="create_name" type="text" class="form-control" name="name">
			    </div>
			</div>
			<br/><br/><br/>

			<div class="form-group">
			    <label class="col-md-4 control-label">Ngày bắt đầu</label>
			    <div class="col-md-8">
			        <div class="input-group date form_datetime">
			            <input type="text" class="form-control" readonly="" size="16" name="start_date" id="create_start_date" value="{{Carbon\Carbon::now()->format('d-m-Y')}}">
			            <span class="input-group-btn">
			            <button type="button" class="btn btn-primary date-set"><i class="fa fa-calendar"></i></button>
			            </span>
			        </div>
			    </div>
			</div>
			<br/><br/>

			<div class="form-group">
			    <label class="col-md-4 control-label">Ngày kết thúc</label>
			    <div class="col-md-8">
			        <div class="input-group date form_datetime">
			            <input type="text" class="form-control" readonly="" size="16" name="end_date" value="{{Carbon\Carbon::now()->format('d-m-Y')}}" id="create_end_date">
			            <span class="input-group-btn">
			            <button type="button" class="btn btn-primary date-set"><i class="fa fa-calendar"></i></button>
			            </span>
			        </div>
			    </div>
			</div>
			<br/><br/>
			<div class="form-group">
				<label for="name" class="col-md-4 control-label"></label>
				<div class="col-md-8" align="right">
					<button type="submit" class="btn btn-primary" id="btn-create-term" onclick="create_term('terms_table')">
						Tạo
					</button>
				</div>
			</div>
		</form>
	</div>
</div>