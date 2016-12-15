<div class="modal-content panel-primary">
    <div class="modal-header" style="background-color: #1ca59e; ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">Phân chức vụ cho quyền {{$permission->name}}</h4>
    </div>
    <div class="modal-content">

    <!-- 2 table s connect -->
    	<div class="table-responsive">
		    <div class="col-md-5">
		        <h4 align="center">Chức vụ có quyền này</h4>
		        <input type="text" id="roles_disconnect" name="roles_disconnect" style="display:none"/>
		        <table class="table table-striped table-bordered table-hover" id="roles_connect_table">
		            <thead>
		                <tr>
		                	<th>STT</th>
		                    <th>Tên</th>
		                    <th>Mã</th>
		                    <th style="display: none"></th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($connect_roles as $connect_role)
		                <tr id="connect-role-row{{$connect_role->id}}" click="0" index_role="{{$connect_role->id}}">
		                	<td></td>
		                    <td>
		                     	{{$connect_role->name}}
		                    </td>
		                    <td>
		                     	{{$connect_role->code}}
		                    </td>
		                    <td style="display: none">
		                        <input type="checkbox"  value="{{$connect_role->id}}" id="role-disconnect{{$connect_role->id}}">
		                    </td>
		                </tr>
		                @endforeach
		            </tbody>
		        </table>
		    </div>

		    <div class="col-md-2" align="center">
		        <h4 align="center">Hành động</h4>
		        <br/><br/><br/><br/>
		        <button type="submit" class="btn btn-lg btn-primary" align="center" id="change" onclick="change_state_permission()">
		            <i class="fa fa-arrows-h"></i>
		        </button>
		    </div>

		    <div class="col-md-5">
		        <h4 align="center">Các chức vụ còn lại</h4>
		        <input type="text" id="roles_connect" name="roles_connect" style="display:none"/>
		        <table class="table table-striped table-bordered table-hover" id="roles_disconnect_table">
		            <thead>
		                <tr>
		                	<th>STT</th>
		                    <th>Tên</th>
		                    <th>Mã</th>
		                    <th style="display: none"></th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($disconnect_roles as $disconnect_role)
		                <tr id="disconnect-role-row{{$disconnect_role->id}}" click="0" index_role="{{$disconnect_role->id}}">
		                	<td></td>
		                    <td>
		                     	{{$disconnect_role->name}}
		                    </td>
		                    <td>
		                     	{{$disconnect_role->code}}
		                    </td>
		                    <td style="display: none">
		                        <input type="checkbox"  value="{{$disconnect_role->id}}" id="role-connect{{$disconnect_role->id}}">
		                    </td>
		                </tr>
		                @endforeach
		            </tbody>
		        </table>
		    </div>
		</div>
    <!-- end tables -->
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        load_check_box_dataTable('roles_disconnect_table','disconnect-role-row','index_role','role-connect','roles_connect');
        load_check_box_dataTable('roles_connect_table','connect-role-row','index_role','role-disconnect','roles_disconnect');
    });

    function change_state_permission(){
        url = 'roles-permissions/permission-connect-roles';

        $.ajax({
            url      : url,
            type     : "POST",
            data     : {
            			permission_id: {{$permission->id}},
                        roles_connect:$('#roles_connect').val(),
                        roles_disconnect:$('#roles_disconnect').val(),
                        },
            success  : function(data){
                    if(data.code != 200 && data.code != undefined)
                        alert(data.message)
                    else{
                        $('#permissions-roles-panel').html(data);
                    }
            },
            error:function(){ 
                alert("Không thực hiện được hành động này!");    
            }
        });
    }
</script>