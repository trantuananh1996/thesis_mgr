<link rel="stylesheet" href="{{URL::asset('table/datatables/media/css/dataTables.bootstrap.min.css')}}"/>
<!-- 2 table s connect -->
	<div class="table-responsive">
	    <div class="col-md-5">
	        <h4 align="center">Những sinh viên trong chương trình đào tạo này</h4>
	        <input type="text" id="students_disconnect{{$cohort_id}}" name="students_disconnect" style="display:none"/>
	        <table class="table table-striped table-bordered table-hover" id="students_connect_table{{$cohort_id}}">
	            <thead>
	                <tr>
	                	<th>STT</th>
	                    <th>Tên</th>
	                    <th>Ngày sinh</th>
	                    <th style="display: none"></th>
	                </tr>
	            </thead>
	            <tbody>
	                @foreach($students_connect as $student_connect)
	                <tr id="{{$cohort_id}}connect-row{{$student_connect->id}}" click="0" index="{{$student_connect->id}}">
	                	<td></td>
	                    <td>
	                     	{{$student_connect->getFullName()}}
	                    </td>
	                    <td>
	                     	{{Carbon\Carbon::parse($student_connect->dob)->format('d-m-Y')}}
	                    </td>
	                    <td style="display: none">
	                        <input type="checkbox"  value="{{$student_connect->id}}" id="{{$cohort_id}}disconnect{{$student_connect->id}}">
	                    </td>
	                </tr>
	                @endforeach
	            </tbody>
	        </table>
	    </div>

	    <div class="col-md-2" align="center">
	        <h4 align="center">Chuyển</h4>
	        <br/><br/><br/><br/>
	        <button type="submit" class="btn btn-lg btn-primary" align="center" id="change" onclick="change_state('students-cohort{{$cohort_id}}')">
	            <i class="fa fa-arrows-h"></i>
	        </button>
	    </div>

	    <div class="col-md-5">
	        <h4 align="center">Tân sinh viên</h4>
	        <input type="text" id="students_connect{{$cohort_id}}" name="students_connect" style="display:none"/>
	        <table class="table table-striped table-bordered table-hover" id="students_disconnect_table{{$cohort_id}}">
	            <thead>
	                <tr>
	                	<th>STT</th>
	                    <th>Tên</th>
	                    <th>Ngày sinh</th>
	                    <th style="display: none"></th>
	                </tr>
	            </thead>
	            <tbody>
	                @foreach($students_disconnect as $student_disconnect)
	                <tr id="{{$cohort_id}}disconnect-row{{$student_disconnect->id}}" click="0" index="{{$student_disconnect->id}}">
	                	<td></td>
	                    <td>
	                     	{{$student_disconnect->getFullName()}}
	                    </td>
	                    <td>
	                     	{{Carbon\Carbon::parse($student_disconnect->dob)->format('d-m-Y')}}
	                    </td>
	                    <td style="display: none">
	                        <input type="checkbox"  value="{{$student_disconnect->id}}" id="{{$cohort_id}}connect{{$student_disconnect->id}}">
	                    </td>
	                </tr>
	                @endforeach
	            </tbody>
	        </table>
	    </div>
	</div>
<!-- end tables -->
<script type="text/javascript">
    $(document).ready(function () {
        load_check_box_dataTable('students_disconnect_table{{$cohort_id}}','{{$cohort_id}}disconnect-row','index','{{$cohort_id}}connect','students_connect{{$cohort_id}}');
        load_check_box_dataTable('students_connect_table{{$cohort_id}}','{{$cohort_id}}connect-row','index','{{$cohort_id}}disconnect','students_disconnect{{$cohort_id}}');
    });

    function change_state(panel_id){
        url = 'cohorts-programs/cohort-connect-students';

        $.ajax({
            url      : url,
            type     : "POST",
            data     : {
            			cohort_id: {{$cohort_id}},
            			program_id: {{$program_id}},
                        students_connect:$('#students_connect{{$cohort_id}}').val(),
                        students_disconnect:$('#students_disconnect{{$cohort_id}}').val(),
                        },
            success  : function(data){
                    if(data.code != 200 && data.code != undefined)
                        alert(data.message)
                    else{
                        $('#'+panel_id).html(data);
                    }
            },
            error:function(){ 
                alert("Không thực hiện được hành động này!");    
            }
        });
    }
</script>