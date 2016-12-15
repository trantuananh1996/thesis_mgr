<div class="modal-content panel-primary">
    <div class="modal-header" style="background-color: #1ca59e; ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel" align="center" style="color: white;">SINH VIÊN ĐANG THỰC HIỆN KHÓA
            LUẬN</h4>
    </div>
    <div class="modal-content">
        <br>
        <div class="prf-box">
            @if($topic->students_learn->count()==0)
                <div align="center">Chưa có sinh viên nào thực hiện khóa luận này</div>
            @endif
            @foreach($topic->students_learn as $student_learn)
                <div class=" wk-progress tm-membr" id="student_learn_row{{$student_learn->id}}">
                    <div class="col-md-3 col-xs-3" align="right">
                        <div class="tm-avatar">
                            <img src="{{asset($student_learn->student->avatar)}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-3">
                        <h4><span class="tm">{{$student_learn->student->getFullName()}}</span></h4>
                    </div>
                    <div class="col-md-6 col-xs-6 pull-right" style="margin-top: 8px">
                        @can('topic_denies')
                            <button class="btn btn-danger tm" onclick="denies_student({{$student_learn->id}})">
                                ĐÌNH CHỈ
                            </button>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script type="text/javascript">
    @can('topic_denies')
    function denies_student(student_topic_id) {
        var run_function = function () {
            $.ajax({
                url: 'topics/denies_student_learn',
                type: "POST",
                data: {
                    topic_id:{{$topic->id}},
                    student_topic_id: student_topic_id
                },
                success: function (data) {
                    if (data.code == 200) {
                        $('#student_learn_row' + student_topic_id).remove();
                        alert(data.message, '', 'success');
                    } else {
                        alert(data.message, '', 'error');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra, vui lòng thực hiện lại', '', 'error');
                }
            });
        };
        confirm('Bạn chắc chắn muốn đình chỉ sinh viên này làm khóa luận ?', 'warning', run_function);
    }
    @endcan
</script>