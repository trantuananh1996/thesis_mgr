<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Topic;
use App\StudentTopic;
use App\Manager\Unit;

use Auth;
use Validator;
use Route;
use Session;
use Gate;

class TopicsController extends Controller
{
    public function __construct(){
    	
    }

    public function index(){
        if(Gate::denies('topics_student'))
            return redirect('/404');

        $student = Auth::user();
        $student->cohort = $student->student_cohort()->with('program')->first();

        if(is_null($student->student_cohort)){
            $topics = collect();
            $unit_name='';
        }
        elseif(is_null($student->student_cohort->program)){
            $topics = collect();
            $unit_name='';
        }
        else{
            $program =  $student->student_cohort->program;
            $unit = Unit::whereId($program->unit_id)->with('fields')->first();
            $unit_name= $unit->name;
            if(empty($unit->fields))
                $topics = collect();
            else{
                $field_ids = $unit->fields->pluck('id')->toArray();
                $topics = Topic::whereIn('field_id',$field_ids)->with('author','field','students_learn','students_register','tutors')->orderBy('updated_at','DESC')->orderBy('name')->get();
            }
        }

        $student->topic = $student->topic()
            ->with('current_topic','current_topic.author','current_topic.field','current_topic.students_learn','current_topic.students_register','current_topic.tutors')
            ->with('register_topic','register_topic.author','register_topic.field','register_topic.students_learn','register_topic.students_register','register_topic.tutors')->first();
            
        if(is_null($student->topic))
            $student->topic = StudentTopic::create_empty($student->id);

    	return view('students.topics.index',compact('topics','unit_name','student'));
    }

    public function info($topic){
        $topic = Topic::whereCode($topic)->with('author','field','students_learn','students_learn.student','students_register','students_register.student','tutors')->first();

        if(is_null($topic))
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors('Không tìm thấy đề tài khóa luận này');

        return view('students.topics.info',compact('topic'));
    }

    public function register(Request $request){
        $data = $request->all();

        if(Gate::denies('topics_student'))
            return response_error(403,'Bạn không có quyền thực hiện thao tác này',$data);

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        $student = Auth::user();
        $student->topic = $student->topic()->first();

        if(is_null($student->topic))
            $student->topic = StudentTopic::create_empty($student->id);

        if($student->topic->register_topic_id !=0 )
            return response_error(403,'Bạn đang đăng ký một đề tài khác, vui lòng hủy đăng ký',$data);

        if($topic->is_locked == 1)
            return response_error(403,'Đề tài này đã đóng đăng ký, vui lòng chọn đề tài khác',$data);

        if($student->topic->can_register == 0)
            return response_error(403,'Bạn không đủ điều kiện để đăng ký khóa luận, vui lòng liên hệ với Nhà trường',$data);            

        $student->topic->register_topic_id = $topic->id;
        $student->topic->save();
        $student->topic->change_status();

        return response_success('Đăng ký đề tài thành công',$data);        
    }

}
