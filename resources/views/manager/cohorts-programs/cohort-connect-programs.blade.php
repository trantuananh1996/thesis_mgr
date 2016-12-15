<div class="modal-content panel-primary">
    <div class="modal-header" style="background-color: #1ca59e; ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">CHƯƠNG TRÌNH ĐÀO TẠO TRONG {{$cohort->name}}</h4>
    </div>
    <div class="modal-content">

    <!-- 2 table s connect -->
    	<div class="table-responsive">
		    <div class="col-md-5">
		        <h4 align="center">Chương trình đào tạo đang có</h4>
		        <input type="text" id="programs_disconnect" name="programs_disconnect" style="display:none"/>
		        <table class="table table-striped table-bordered table-hover" id="programs_connect_table">
		            <thead>
		                <tr>
		                    <th>Tên</th>
		                    <th>Mã</th>
		                    <th style="display: none"></th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($connect_programs as $connect_program)
		                <tr id="connect-row{{$connect_program->id}}" click="0" index="{{$connect_program->id}}">
		                    <td>
		                     	{{$connect_program->name}}
		                    </td>
		                    <td>
		                     	{{$connect_program->code}}
		                    </td>
		                    <td style="display: none">
		                        <input type="checkbox"  value="{{$connect_program->id}}" id="disconnect{{$connect_program->id}}">
		                    </td>
		                </tr>
		                @endforeach
		            </tbody>
		        </table>
		    </div>

		    <div class="col-md-2" align="center">
		        <h4 align="center">Chuyển</h4>
		        <br/><br/><br/><br/>
		        <button type="submit" class="btn btn-lg btn-primary" align="center" id="change" onclick="change_state()">
		            <i class="fa fa-arrows-h"></i>
		        </button>
		    </div>

		    <div class="col-md-5">
		        <h4 align="center">Chương trình đào tạo khác</h4>
		        <input type="text" id="programs_connect" name="programs_connect" style="display:none"/>
		        <table class="table table-striped table-bordered table-hover" id="programs_disconnect_table">
		            <thead>
		                <tr>
		                    <th>Tên</th>
		                    <th>Mã</th>
		                    <th style="display: none"></th>
		                </tr>
		            </thead>
		            <tbody>
		                @foreach($disconnect_programs as $disconnect_program)
		                <tr id="disconnect-row{{$disconnect_program->id}}" click="0" index="{{$disconnect_program->id}}">
		                    <td>
		                     	{{$disconnect_program->name}}
		                    </td>
		                    <td>
		                     	{{$disconnect_program->code}}
		                    </td>
		                    <td style="display: none">
		                        <input type="checkbox"  value="{{$disconnect_program->id}}" id="connect{{$disconnect_program->id}}">
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
        load_check_box_dataTable('programs_disconnect_table','disconnect-row','index','connect','programs_connect');
        load_check_box_dataTable('programs_connect_table','connect-row','index','disconnect','programs_disconnect');
    });

    function change_state(){
        url = 'cohort-connect-programs';

        $.ajax({
            url      : url,
            type     : "POST",
            data     : {
            			cohort_id: {{$cohort->id}},
                        programs_connect:$('#programs_connect').val(),
                        programs_disconnect:$('#programs_disconnect').val(),
                        },
            success  : function(data){
                    if(data.code != 200 && data.code != undefined)
                        alert(data.message)
                    else{
                        $('#cohorts-programs-panel').html(data);
                    }
            },
            error:function(){ 
                alert("Không thực hiện được hành động này!");    
            }
        });
    }
</script>