<aside class="profile-nav alt" id="topic-panel{{$topic->id}}">
    <section class="panel">
        <div class="user-heading alt gray-bg" style="min-height: 192px">
            <div class="col-md-4">
                <a href="#" style="margin-left: -30px">
                    <img alt="" src="{{asset($topic->author->avatar)}}">
                </a>
            </div>
            <div class="col-md-8">
                <h1>{{$topic->author->getFullName()}}</h1>
                @can('topics_teacher')
                <a style="all:unset" href="{{asset('topics/'.$topic->code.'/edit')}}" target="_blank">
                    <p>{{$topic->name}}</p>
                </a>
                @else
                    <p>{{$topic->name}}</p>
                @endcan
            </div>
        </div>
        <div class="weather-category twt-category">
            <ul>
                <li class="active">
                    <h5>
                        <b class="text text-danger">{{count($topic->students_learn)}}</b> SV
                    </h5>
                    THỰC HIỆN
                </li>
                <li>
                    <h5>
                        <b class="text text-success">{{count($topic->students_register)}}</b> SV
                    </h5>
                    XIN ĐĂNG KÝ
                </li>
                <li>
                    <a data-toggle="modal" data-target="#tutors-topic-modal" href="#" style="all:unset" id="btn-topic-tutors{{$topic->id}}" index="{{$topic->id}}">
                        <h5>
                            <b class="text text-info">{{count($topic->tutors)}}</b> GV
                        </h5>
                        HƯỚNG DẪN
                    </a>
                </li>
            </ul>
        </div>
        <div class="twt-write col-sm-12">
            <div class="col-md-6"> 
                <span class="text text-primary"><b>{{$topic->field->name}}</b></span>
            </div>
            <div class="col-md-6" align="right">
                @if($topic->is_locked == 1)
                    <button class="btn btn-danger" id="btn-change-locked{{$topic->id}}" title="Mở đăng ký" index="{{$topic->id}}" >
                        <i class="fa fa-lock"></i>
                    </button>
                @else
                    <button class="btn btn-info" id="btn-change-locked{{$topic->id}}" title="Khóa đăng ký" index="{{$topic->id}}" >
                        <i class="fa fa-unlock"></i>
                    </button>
                @endif

                @can('topics_teacher')
                    @if($topic->created_user_id == Auth::user()->id)
                        @if(count($topic->students_learn) == 0 && count($topic->students_register) == 0)
                            <button class="btn btn-danger" id="btn-delete-topic{{$topic->id}}" index="{{$topic->id}}" title="Xóa">
                                <i class="fa fa-times"></i>
                            </button>     
                        @endif
                    @endif
                @endcan
            </div>
        </div>
    </section>
</aside>
@section('load-html-script')

@endsection