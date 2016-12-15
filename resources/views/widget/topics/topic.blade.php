@if(isset($mark))
<aside class="profile-nav alt" id="topic-panel-mark-student{{$topic->id}}" style="margin-top: 15px">
@else
<aside class="profile-nav alt" id="topic-panel{{$topic->id}}" style="margin-top: 15px">
@endif
    <section class="panel">
        @if(isset($mark))
        <div class="twt-feed blue-bg" id="mark-student">
            <div class="corner-ribon black-ribon">
                <i class="fa fa-tag"></i>
            </div>
            <div class="fa fa-star wtt-mark"></div>
            <a href="#">
                <img alt="" src="{{asset($topic->author->avatar)}}">
            </a>
            <h1>{{$topic->author->getFullName()}}</h1>
            <a style="all:unset" href="{{asset('topics/'.$topic->code.'/info')}}" target="_blank">
                <p>{{$topic->name}}</p>
            </a>
        </div>
        @else
        <div class="user-heading alt gray-bg" style="min-height: 192px">
            <div class="col-md-4">
                <a href="#" style="margin-left: -30px">
                    <img alt="" src="{{asset($topic->author->avatar)}}">
                </a>
            </div>
            <div class="col-md-8">
                <h1>{{$topic->author->getFullName()}}</h1>
                <a style="all:unset" href="{{asset('topics/'.$topic->code.'/info')}}" target="_blank">
                    <p>{{$topic->name}}</p>
                </a>
            </div>
        </div>
        @endif
        <div class="weather-category twt-category">
            <ul>
                <li class="active">
                    @if($topic->created_user_id == Auth::user()->id)
                    <a data-toggle="modal" data-target="#students-learn-topic-modal" href="#" style="all:unset" id="btn-topic-students-learn{{$topic->id}}" index="{{$topic->id}}">
                    @endif
                    <h5>
                        <b class="text text-danger">{{count($topic->students_learn)}}</b> SV
                    </h5>
                    THỰC HIỆN
                    @if($topic->created_user_id == Auth::user()->id)
                    </a>
                    @endif
                </li>
                <li>
                    @if($topic->created_user_id == Auth::user()->id)
                    <a data-toggle="modal" data-target="#students-register-topic-modal" href="#" style="all:unset" id="btn-topic-students-register{{$topic->id}}" index="{{$topic->id}}">
                    @endif
                    <h5>
                        <b class="text text-success">{{count($topic->students_register)}}</b> SV
                    </h5>
                    XIN ĐĂNG KÝ
                    @if($topic->created_user_id == Auth::user()->id)
                    </a>
                    @endif
                </li>
                <li>
                    @if($topic->created_user_id == Auth::user()->id)
                    <a data-toggle="modal" data-target="#tutors-topic-modal" href="#" style="all:unset" id="btn-topic-tutors{{$topic->id}}" index="{{$topic->id}}">
                    @endif
                        <h5>
                            <b class="text text-info">{{count($topic->tutors)}}</b> GV
                        </h5>
                        HƯỚNG DẪN
                    @if($topic->created_user_id == Auth::user()->id)
                    </a>
                    @endif
                </li>
            </ul>
        </div>
        <div class="twt-write row" style="min-height: 50px">
            <div class="col-md-5" align="center"> 
                <span class="text text-primary"><b>{{$topic->field->name}}</b></span>
            </div>
            <div class="col-md-7" align="center">
                @can('topics_teacher')

                    @if($topic->is_locked == 1)
                        <button class="btn btn-danger" id="btn-change-locked{{$topic->id}}" title="Mở đăng ký" index="{{$topic->id}}" >
                            <i class="fa fa-lock"></i>
                        </button>
                    @else
                        <button class="btn btn-info" id="btn-change-locked{{$topic->id}}" title="Khóa đăng ký" index="{{$topic->id}}" >
                            <i class="fa fa-unlock"></i>
                        </button>
                    @endif

                    @if($topic->created_user_id == Auth::user()->id)
                        @if(count($topic->students_learn) == 0 && count($topic->students_register) == 0)
                            <button class="btn btn-danger" id="btn-delete-topic{{$topic->id}}" index="{{$topic->id}}" title="Xóa">
                                <i class="fa fa-times"></i>
                            </button>     
                        @endif
                    @endif

                @endcan

                @can('topics_student')
                    <span id='topic_student_footer{{$topic->id}}'>
                    @if($topic->id == $student->topic->current_topic_id)
                        <p class="text text-info"><b>ĐÃ NHẬN ĐỀ TÀI</b></p> 
                    @elseif($topic->id == $student->topic->register_topic_id)
                        <p class="text text-primary">CHỜ PHÊ DUYỆT ...
                        <button class="btn btn-danger pull-right" id="btn-cancel-register{{$topic->id}}" title="Hủy đăng ký" index="{{$topic->id}}" >
                            <i class="fa fa-times"></i>
                        </button>
                        </p> 
                    @elseif($topic->is_locked == 1)
                        <button class="btn btn-default">
                            KHÓA ĐĂNG KÝ <i class="fa fa-lock"></i>
                        </button>
                    @elseif($topic->is_locked == 0)
                        <button class="btn btn-info" id="btn-register{{$topic->id}}" title="Đăng ký" index="{{$topic->id}}" >
                            ĐĂNG KÝ <i class="fa fa-pencil"></i>
                        </button>
                    @endif
                    </span>
                @endcan
            </div>
        </div>
    </section>
</aside>
@section('load-html-script')

@endsection