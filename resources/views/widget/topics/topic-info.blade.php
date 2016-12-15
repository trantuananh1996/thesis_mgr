 <div class="panel panel-success">
    <div class="panel-heading" style="background-color: #1ca59e; color: white" align="center">{{$topic->name}}</div>
    <div class="panel-body">
    	<div class="col-md-8">
    		<div class="form-group">
                <div class="col-md-6 alert alert-info">
                    <h5>GIẢNG VIÊN KHỞI TẠO : {{$topic->author->getFullName()}}</h5>
                </div>
                <div class="col-md-6 alert alert-info" align="right">
                    <h5>Lĩnh vực: {{$topic->field->name}}</h5>
                </div>
            </div>
            <div class="form-group">
	            <?php echo $topic->description; ?>
	        </div>
    	</div>
    	<div class="col-md-4">
    		<div class="prf-box">
                <h3 class="prf-border-head">GIẢNG VIÊN HƯỚNG DẪN</h3>
                @foreach($topic->tutors as $tutor)
                <div class=" wk-progress tm-membr">
                    <div class="col-md-4 col-xs-4">
                        <div class="tm-avatar">
                            <img src="{{asset($tutor->avatar)}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-8">
                        <span class="tm">{{$tutor->getFullName()}}</span>
                    </div>
                </div>
                @endforeach
            </div>

            @if(count($topic->students_learn) > 0)
            <div class="prf-box">
                <h3 class="prf-border-head">SINH VIÊN ĐANG THỰC HIỆN</h3>
                @foreach($topic->students_learn as $student_topic)
                <div class=" wk-progress tm-membr">
                    <div class="col-md-4 col-xs-4">
                        <div class="tm-avatar">
                            <img src="{{asset($student_topic->student->avatar)}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-8">
                        <span class="tm">{{$student_topic->student->getFullName()}}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(count($topic->students_register) > 0)
            <div class="prf-box">
                <h3 class="prf-border-head">SINH VIÊN XIN ĐĂNG KÝ</h3>
                @foreach($topic->students_register as $student_topic)
                <div class=" wk-progress tm-membr">
                    <div class="col-md-4 col-xs-4">
                        <div class="tm-avatar">
                            <img src="{{asset($student_topic->student->avatar)}}" alt="">
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-8">
                        <span class="tm">{{$student_topic->student->getFullName()}}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
    	</div>
    </div>
</div>