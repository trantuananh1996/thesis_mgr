<div class="modal-content panel-primary">
    <div class="modal-header" style="background-color: #1ca59e; ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">DANH SÁCH CÁC GIÁO VIÊN THUỘC LĨNH VỰC {{$field->name}}</h4>
    </div>
    <div class="modal-content">
        <!-- 2 table s connect -->
        <div class="table-responsive">
            <div class="col-md-5">
                <h4 align="center">Các giáo viên phụ trách lĩnh vực</h4>
                <input type="text" id="teacher_disconnect" name="teacher_disconnect" style="display:none"/>
                <table class="table table-striped table-bordered table-hover" id="teacher_connect_table">
                    <thead>
                    <tr>
                        <th>Tài khoản</th>
                        <th>Email</th>
                        <th>Tên</th>
                        <th style="display: none"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teachers_connect as $teacher)
                        <tr id="connect-row{{$teacher->id}}" click="0" index="{{$teacher->id}}">
                            <td>
                                {{$teacher->username}}
                            </td>
                            <td>
                                {{$teacher->email}}
                            </td>
                            <td>
                                {{$teacher->getFullName()}}
                            </td>
                            <td style="display: none">
                                <input type="checkbox" value="{{$teacher->id}}" id="disconnect{{$teacher->id}}">
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
                <h4 align="center">Các giáo viên thuộc đơn vị</h4>
                <input type="text" id="teacher_connect" name="teacher_connect" style="display:none"/>
                <table class="table table-striped table-bordered table-hover" id="teacher_disconnect_table">
                    <thead>
                    <tr>
                        <th>Tài khoản</th>
                        <th>Email</th>
                        <th>Tên</th>
                        <th style="display: none"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($teachers_disconnect as $teacher)
                        <tr id="disconnect-row{{$teacher->id}}" click="0" index="{{$teacher->id}}">
                            <td>
                                {{$teacher->username}}
                            </td>
                            <td>
                                {{$teacher->email}}
                            </td>
                            <td>
                                {{$teacher->getFullName()}}
                            </td>
                            <td style="display: none">
                                <input type="checkbox" value="{{$teacher->id}}" id="connect{{$teacher->id}}">
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
        load_check_box_dataTable('teacher_disconnect_table', 'disconnect-row', 'index', 'connect', 'teacher_connect');
        load_check_box_dataTable('teacher_connect_table', 'connect-row', 'index', 'disconnect', 'teacher_disconnect');
    });

    function change_state() {
        url = 'field/teacher-connect-field';

        $.ajax({
            url: url,
            type: "POST",
            data: {
                field_id: {{$field->id}},
                teacher_connect: $('#teacher_connect').val(),
                teacher_disconnect: $('#teacher_disconnect').val(),
            },
            success: function (data) {
                if (data.code != 200 && data.code != undefined)
                    alert(data.message)
                else {
                    $('#teacher-field-panel').html(data);
                }
            },
            error: function () {
                alert("Không thực hiện được hành động này!","Lỗi",'error');
            }
        });
    }
</script>