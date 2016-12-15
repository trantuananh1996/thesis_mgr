<div class="modal-content panel-primary">
    <div class="modal-header" style="background-color: #1ca59e; ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">DANH SÁCH CÁC SINH VIÊN ĐỦ ĐIỀU
            KIỆN ĐĂNG KÝ ĐỢT {{$term->name}}</h4>
    </div>
    <div class="modal-content">
        <!-- 2 table s connect -->
        <div class="table-responsive">
            <div class="col-md-5">
                <h4 align="center">Các sinh viên đủ điều kiện</h4>
                <input type="text" id="student_disconnect" name="student_disconnect" style="display:none"/>
                <table class="table table-striped table-bordered table-hover" id="student_connect_table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã sinh viên</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th style="display: none"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students_connect as $student)
                        <tr id="connect-row{{$student->id}}" click="0" index="{{$student->id}}">
                            <td></td>
                            <td>
                                {{$student->username}}
                            </td>
                            <td>
                                {{$student->getFullName()}}
                            </td>
                            <td>
                                {{$student->email}}

                            </td>
                            <td style="display: none">
                                <input type="checkbox" value="{{$student->id}}" id="disconnect{{$student->id}}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-2" align="center">
                <h4 align="center">Chuyển</h4>
                <br/><br/><br/><br/>
                <button type="submit" class="btn btn-lg btn-primary" align="center" id="change"
                        onclick="change_state()">
                    <i class="fa fa-arrows-h"></i>
                </button>
            </div>

            <div class="col-md-5">
                <h4 align="center">Các sinh viên đủ điều kiện</h4>
                <input type="text" id="student_connect" name="student_connect" style="display:none"/>
                <table class="table table-striped table-bordered table-hover" id="student_disconnect_table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tài khoản</th>
                        <th>Tên</th>
                        <th>Email</th>

                        <th style="display: none"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students_disconnect as $student)
                        <tr id="disconnect-row{{$student->id}}" click="0" index="{{$student->id}}">
                            <td></td>
                            <td>
                                {{$student->username}}
                            </td>
                            <td>
                                {{$student->getFullName()}}
                            </td>
                            <td>
                                {{$student->email}}
                            </td>

                            <td style="display: none">
                                <input type="checkbox" value="{{$student->id}}" id="connect{{$student->id}}">
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
        load_check_box_dataTable('student_disconnect_table', 'disconnect-row', 'index', 'connect', 'student_connect');
        load_check_box_dataTable('student_connect_table', 'connect-row', 'index', 'disconnect', 'student_disconnect');
    });

    function change_state() {
        url = 'show-student-connect-term';
        $.ajax({
            url: url,
            type: "POST",
            data: {
                term_id: {{$term->id}},
                student_connect: $('#student_connect').val(),
                student_disconnect: $('#student_disconnect').val(),
            },
            success: function (data) {
                if (data.code != 200 && data.code != undefined)
                    alert(data.message);
                else {
                    $('#student-field-panel').html(data);
                    $.ajax({
                        url: 'reload-student-connect',
                        type: "POST",
                        data: {
                            term_id: {{$term->id}}
                        },
                        success: function (data) {
                            console.log(data);
                            $('#student-list-table').html(data);
                            $('#students-fields').modal('toggle');
                        },
                        error: function () {
                            alert("Không thực hiện được hành động này!", "Lỗi", 'error');
                        }
                    });
                }
            },
            error: function () {
                alert("Không thực hiện được hành động này!", "Lỗi", 'error');
            }
        });
    }
</script>