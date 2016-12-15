@if(count($students) == 0)
    <div class="alert alert-info">
        <p>Hiện chưa có học sinh nào đủ điều kiện đăng ký đề tài trong đợt này</p>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="student_tables">
            <thead>
            <tr>
                <th><p>STT</p></th>
                <th><p>Hình ảnh</p></th>
                <th><p>Tài khoản</p></th>
                <th><p>Họ và tên</p></th>
                <th><p>Email</p></th>
                <th><p>Khoa</p></th>
                <th><p>Khóa học</p></th>
                <th><p>Điện thoại</p></th>
                {{--<th><p>Tùy chọn</p></th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($students as $index=>$student)
                <tr>
                    <td style="text-align: center">{{$index + 1}}</td>
                    <td style="text-align: center"><img width="50px"
                                                        src="{{asset($student->avatar)}}">
                    </td>
                    <td>{{$student->username}}</td>
                    <td>{{$student->getFullName()}}</td>
                    <td>{{$student->email}}</td>
                    <td>{{$student->cohort_name}}</td>
                    <td>{{$student->program_name}}</td>
                    <td>{{$student->phone}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif