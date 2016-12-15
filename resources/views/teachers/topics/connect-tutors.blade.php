<div class="modal-content panel-primary">
    <div class="modal-header" style="background-color: #1ca59e; ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">PHÂN GIẢNG VIÊN THAM GIA KHÓA
            LUẬN</h4>
    </div>
    <div class="modal-content">
        <div class="row" align="center"><h4 class="text text-default">Đề tài: {{$topic->name}}</h4></div>
        <br/>
        <!-- 2 table s connect -->
        <div class="table-responsive">
            <div class="col-md-5">
                <h4 align="center">GIẢNG VIÊN ĐÃ THAM GIA</h4>
                <input type="text" id="tutors_disconnect" name="tutors_disconnect" style="display:none"/>
                @if ($connect_tutors->count()==0)
                    <div align="center">Chưa có giảng viên nào tham gia hướng dẫn khóa luận cùng bạn</div>
                @else
                    <table class="table table-striped table-bordered table-hover" id="tutors_connect_table">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Ngày sinh</th>
                            <th style="display: none"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($connect_tutors as $connect_tutor)
                            <tr id="connect-row{{$connect_tutor->id}}" click="0" index="{{$connect_tutor->id}}">
                                <td></td>
                                <td>
                                    {{$connect_tutor->getFullName()}}
                                </td>
                                <td>
                                    {{Carbon\Carbon::parse($connect_tutor->dob)->format('d-m-Y')}}
                                </td>
                                <td style="display: none">
                                    <input type="checkbox" value="{{$connect_tutor->id}}"
                                           id="disconnect{{$connect_tutor->id}}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="col-md-2" align="center">
                <h4 align="center">Hành động</h4>
                <br/><br/><br/><br/>
                <button type="submit" class="btn btn-lg btn-primary" align="center" id="change"
                        onclick="change_state()">
                    <i class="fa fa-arrows-h"></i>
                </button>
            </div>

            <div class="col-md-5">
                <h4 align="center">GIẢNG VIÊN CÙNG LĨNH VỰC NGHIÊN CỨU</h4>
                <input type="text" id="tutors_connect" name="tutors_connect" style="display:none"/>
                <table class="table table-striped table-bordered table-hover" id="tutors_disconnect_table">
                    <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ngày sinh</th>
                        <th style="display: none"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($disconnect_tutors as $disconnect_tutor)
                        <tr id="disconnect-row{{$disconnect_tutor->id}}" click="0" index="{{$disconnect_tutor->id}}">
                            <td></td>
                            <td>
                                {{$disconnect_tutor->getFullName()}}
                            </td>
                            <td>
                                {{Carbon\Carbon::parse($disconnect_tutor->dob)->format('d-m-Y')}}
                            </td>
                            <td style="display: none">
                                <input type="checkbox" value="{{$disconnect_tutor->id}}"
                                       id="connect{{$disconnect_tutor->id}}">
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
        load_check_box_dataTable('tutors_disconnect_table', 'disconnect-row', 'index', 'connect', 'tutors_connect');
        load_check_box_dataTable('tutors_connect_table', 'connect-row', 'index', 'disconnect', 'tutors_disconnect');
    });

    function change_state() {
        $.ajax({
            url: 'topics/connect-tutors',
            type: "POST",
            data: {
                topic_id: {{$topic->id}},
                tutors_connect: $('#tutors_connect').val(),
                tutors_disconnect: $('#tutors_disconnect').val(),
            },
            success: function (data) {
                if (data.code != 200 && data.code != undefined)
                    alert(data.message)
                else {
                    $('#tutors-topic-panel').html(data);
                }
            },
            error: function () {
                alert("Không thực hiện được hành động này!");
            }
        });
    }
</script>