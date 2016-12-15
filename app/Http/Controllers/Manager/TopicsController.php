<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Validator;
use Route;
use Session;
use Gate;

use App\User;
use App\Topic;
use App\StudentTopic;
use App\Manager\Field;
use App\Manager\Unit;

class TopicsController extends Controller
{
    public function __construct(){
    	
    }

    public function index(){

    	if(Gate::denies('topics_manage'))
    		return redirect('404');
    	
    	$topics = Topic::with('field','field.unit','author')->orderBy('field_id')->orderBy('updated_at')->get();

    	return view('manager.topics.index',compact('topics'));
    }

    public function info($topic){
        $topic = Topic::whereCode($topic)->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors('Không tìm thấy đề tài khóa luận này');

        return view('manager.topics.info',compact('topic'));
    }

    public function change_locked(Request $request){
        $data = $request->all();

        if(Gate::denies('topics_manage'))
            return response_error(403,'Bạn không có quyền thực hiện thao tác này',$data);

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        if($topic->is_locked == 1){
            $topic->is_locked = 0;
            $topic->save();
            return response_success('Mở đăng ký đề tài thành công',0);        
        }else{
            $topic->is_locked = 1;
            $topic->save();
            return response_success('Khóa đăng ký đề tài thành công',1);        
        }

    }

    public function delete(Request $request){

        $data = $request->all();

        if(Gate::denies('topics_manage'))
            return response_error(403,'Bạn không có quyền thực hiện thao tác này',$data);

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        if(count($topic->students_learn) > 0 || count($topic->students_register) > 0)
            return response_error(403,'Đã có sinh viên đăng ký hoặc tham gia đề tài này, vui lòng liên hệ Người hướng dẫn và sinh viên',$data);

        $topic->delete();
        
        return response_success('Xóa đề tài thành công',$data);        
    }

    public function denies_student_learn(Request $request){
        $data = $request->all();

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','field.teachers','students_learn','students_learn.student','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        $student_topic = StudentTopic::whereId($data['student_topic_id'])->with('student')->first();

        if(is_null($student_topic))
            return response_error(404,'Không tìm thấy đăng ký này',$data);            

        $student_topic->current_topic_id = 0;
        $student_topic->teacher_accepted = 0;
        $student_topic->save();
        $student_topic->change_status();

        $topic->send_email_register($student_topic->student, Auth::user(),2);
        return response_success('Đình chỉ thành công',$data);            
    }

    public function accept_student_protected(Request $request){
        $data = $request->all();

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','field.teachers','students_learn','students_learn.student','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        $student_topic = StudentTopic::whereId($data['student_topic_id'])->with('student')->first();

        if(is_null($student_topic))
            return response_error(404,'Không tìm thấy đăng ký này',$data);            

        $student_topic->status = 3;
        $student_topic->save();

        $topic->send_email_register($student_topic->student, Auth::user(),3);
        return response_success('Đã cho phép sinh viên được bảo vệ Khóa luận này',$data);            
    }



}
