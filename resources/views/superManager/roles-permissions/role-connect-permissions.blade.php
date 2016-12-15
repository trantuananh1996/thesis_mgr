<div class="modal-content panel-primary">
    <div class="modal-header" style="background-color: #1ca59e; ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">Phân quyền cho chức vụ {{$role->name}}</h4>
    </div>
    <div class="modal-content">

    <!-- 2 table s connect -->
    	<div class="table-responsive">
		    <div class="col-md-5">
		        <h4 align="center">Quyền đã kết nối</h4>
		        <input type="text" id="permissions_disconnect" name="permissions_disconnect" style="display:none"/>
		        <table class="table table-striped table-bordered table-hover" id="permissions_connect_table">
		            <thead>
		                <tr>
		                	<th>STT</th>
		                    <th>Tên</th>
		                    <th>Mã</th>
		                    <th style="display: none"></th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($connect_permissions as $connect_permission)
		                <tr id="connect-row{{$connect_permission->id}}" click="0" index="{{$connect_permission->id}}">
		                	<td></td>
		                    <td>
		                     	{{$connect_permission->name}}
		                    </td>
		                    <td>
		                     	{{$connect_permission->code}}
		                    </td>
		                    <td style="display: none">
		                        <input type="checkbox"  value="{{$connect_permission->id}}" id="disconnect{{$connect_permission->id}}">
		                    </td>
		                </tr>
		                @endforeach
		            </tbody>
		        </table>
		    </div>

		    <div class="col-md-2" align="center">
		        <h4 align="center">Hành động</h4>
		        <br/><br/><br/><br/>
		        <button type="submit" class="btn btn-lg btn-primary" align="center" id="change" onclick="change_state()">
		            <i class="fa fa-arrows-h"></i>
		        </button>
		    </div>

		    <div class="col-md-5">
		        <h4 align="center">Quyền chưa kết nối</h4>
		        <input type="text" id="permissions_connect" name="permissions_connect" style="display:none"/>
		        <table class="table table-striped table-bordered table-hover" id="permissions_disconnect_table">
		            <thead>
		                <tr>
		                	<th>STT</th>
		                    <th>Tên</th>
		                    <th>Mã</th>
		                    <th style="display: none"></th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($disconnect_permissions as $disconnect_permission)
		                <tr id="disconnect-row{{$disconnect_permission->id}}" click="0" index="{{$disconnect_permission->id}}">
		                	<td></td>
		                    <td>
		                     	{{$disconnect_permission->name}}
		                    </td>
		                    <td>
		                     	{{$disconnect_permission->code}}
		                    </td>
		                    <td style="display: none">
		                        <input type="checkbox"  value="{{$disconnect_permission->id}}" id="connect{{$disconnect_permission->id}}">
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
        load_check_box_dataTable('permissions_disconnect_table','disconnect-row','index','connect','permissions_connect');
        load_check_box_dataTable('permissions_connect_table','connect-row','index','disconnect','permissions_disconnect');
    });

    function change_state(){
        url = 'roles-permissions/role-connect-permissions';

        $.ajax({
            url      : url,
            type     : "POST",
            data     : {
            			role_id: {{$role->id}},
                        permissions_connect:$('#permissions_connect').val(),
                        permissions_disconnect:$('#permissions_disconnect').val(),
                        },
            success  : function(data){
                    if(data.code != 200 && data.code != undefined)
                        alert(data.message)
                    else{
                        $('#roles-permissions-panel').html(data);
                    }
            },
            error:function(){ 
                alert("Không thực hiện được hành động này!");    
            }
        });
    }
</script>