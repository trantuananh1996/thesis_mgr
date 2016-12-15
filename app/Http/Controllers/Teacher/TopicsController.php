<?php

namespace App\Http\Controllers\Teacher;

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

class TopicsController extends Controller
{

    public function __construct(){
    	
    }

    public function index(){
    	$user = Auth::user();
    	$topics = $user->teacher_topics()->with('author','field','students_learn','students_register','tutors')->orderBy('updated_at','DESC')->orderBy('name')->get();

    	$assist_topics = $topics->filter(function($topic,$key) use ($user){
    		return $topic->created_user_id != $user->id;
    	});

    	$my_topics = $topics->filter(function($topic,$key) use ($user){
    		return $topic->created_user_id == $user->id;
    	});
        
    	return view('teachers.topics.index',compact('user','assist_topics','my_topics'));
    }

    public function create(){
    	$user = Auth::user();

    	$fields = $user->teacher_fields()->orderBy('name')->get();

    	return view('teachers.topics.create',compact('fields'));
    }

    public function store(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'name'              => 'required|unique:topics',
            'description'       => 'required',
            'field_id'          => 'required|numeric|min:1'
        ]);

        if ($validator->fails())
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors($validator);

        $data['created_user_id'] = Auth::user()->id;
        $data['modified_user_id'] = Auth::user()->id;
        $data['code'] = $this->make_code($data['field_id']);

        $topic = Topic::create($data);

        Auth::user()->teacher_topics()->save($topic);
        Session::flash('message','Tạo đề tài khóa luận thành công');
        return redirect('/teacher/topics');
    }

    public function info($topic){
        $topic = Topic::whereCode($topic)->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors('Không tìm thấy đề tài khóa luận này');

        return view('teachers.topics.info',compact('topic'));
    }

    public function edit($topic){
        $topic = Topic::whereCode($topic)->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors('Không tìm thấy đề tài khóa luận này');

        return view('teachers.topics.edit',compact('topic'));
    }

    public function update($topic,Request $request){
        $data = $request->all();
        $topic = Topic::whereCode($topic)->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors('Không tìm thấy đề tài khóa luận này');

        $validator = Validator::make($data, [
            'name'              => 'required',
            'description'       => 'required'
        ]);

        if ($validator->fails())
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors($validator);

        $topic->update($data);

        Session::flash('message','Cập nhật thông tin thành công');
        return redirect(redirect()->getUrlGenerator()->previous());

    }

    public function delete(Request $request){

        $data = $request->all();

        if(Gate::denies('topics_teacher'))
            return response_error(403,'Bạn không có quyền thực hiện thao tác này',$data);

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        if(count($topic->students_learn) > 0 || count($topic->students_register) > 0)
            return response_error(403,'Đã có sinh viên đăng ký hoặc tham gia đề tài này, vui lòng liên hệ Nhà trường',$data);

        if($topic->created_user_id != Auth::user()->id)
            return response_error(403,'Chỉ tác giả của đề tài mới thực hiện được thao tác này',$data);

        $topic->delete();
        
        return response_success('Xóa đề tài thành công',$data);        
    }

    public function change_locked(Request $request){
        $data = $request->all();

        if(Gate::denies('topics_teacher'))
            return response_error(403,'Bạn không có quyền thực hiện thao tác này',$data);

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        if($topic->created_user_id != Auth::user()->id)
            return response_error(403,'Chỉ tác giả của đề tài mới thực hiện được thao tác này',$data);

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

    public function connect_tutors(Request $request){
        $data = $request->all();

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','field.teachers','students_learn','students_register','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        if(isset($data['tutors_connect']) && $data['tutors_connect']!= null && $data['tutors_connect'] != ''){
            $data['tutors_connect'] = explode(',', $data['tutors_connect']);
            $topic->tutors()->attach($data['tutors_connect']);
            $topic->tutors = $topic->tutors()->get();
        }

        if(isset($data['tutors_disconnect']) && $data['tutors_disconnect']!= null && $data['tutors_disconnect'] != ''){
            $data['tutors_disconnect'] = explode(',', $data['tutors_disconnect']);
            $topic->tutors()->detach($data['tutors_disconnect']);
            $topic->tutors = $topic->tutors()->get();
        }


        if(empty($topic->tutors))
            $tutor_ids = array();
        else{
            $topic->tutors = $topic->tutors->filter(function($tutor,$key) use ($topic){
                return $tutor->id != $topic->created_user_id;
            });
            $tutor_ids = $topic->tutors->pluck('id')->toArray();
        }

        if(is_null($topic->field)){
            $disconnect_tutors = array();            
        }else{
            if(empty($topic->field->teachers))
                $disconnect_tutors = array();            
            else
                $disconnect_tutors = $topic->field->teachers
                        ->filter(function($teacher,$key) use($tutor_ids,$topic){
                            return !in_array($teacher->id, $tutor_ids) && $teacher->id!= $topic->created_user_id;
                        });
        }

        $connect_tutors = $topic->tutors;

        return view('teachers.topics.connect-tutors',compact('topic','connect_tutors','disconnect_tutors'));
    }

    public function show_students_register(Request $request){
        $data = $request->all();

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','field.teachers','students_register','students_register.student','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        return view('teachers.topics.students-register',compact('topic'));
    }
    public function show_students_accepted(Request $request){
        $data = $request->all();

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','field.teachers','students_register','students_register.student','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        return view('teachers.topics.students-accepted',compact('topic'));
    }
    public function accept_student_register(Request $request){
        $data = $request->all();

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','field.teachers','students_register','students_register.student','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        $student_topic = StudentTopic::whereId($data['student_topic_id'])->with('student')->first();

        if(is_null($student_topic))
            return response_error(404,'Không tìm thấy đăng ký này',$data);            

        $student_topic->current_topic_id = $topic->id;
        $student_topic->register_topic_id = 0;
        $student_topic->teacher_id = $topic->created_user_id;
        $student_topic->teacher_accepted = 1;
        $student_topic->status = 2;
        $student_topic->save();

        $topic->send_email_register($student_topic->student, $topic->author,1);
        return response_success('Cho phép thành công',$data);            
    }

    public function denies_student_register(Request $request){
        $data = $request->all();

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','field.teachers','students_register','students_register.student','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        $student_topic = StudentTopic::whereId($data['student_topic_id'])->with('student')->first();

        if(is_null($student_topic))
            return response_error(404,'Không tìm thấy đăng ký này',$data);            

        $student_topic->register_topic_id = 0;
        $student_topic->save();
        $student_topic->change_status();

        $topic->send_email_register($student_topic->student, $topic->author,0);
        return response_success('Từ chối thành công',$data);            
    }

    public function show_students_learn(Request $request){
        $data = $request->all();

        if(is_null($data['topic_id']))
            return response_error(32,'Thiếu dữ liệu gửi lên',$data);

        $topic = Topic::whereId($data['topic_id'])->with('author','field','field.teachers','students_learn','students_learn.student','tutors')->first();

        if(is_null($topic))
            return response_error(404,'Không tìm thấy đề tài này',$data);

        return view('teachers.topics.students-learn',compact('topic'));
    }

    

    public function make_code($field_id){
        $max_id = Topic::whereRaw('id = (select max(`id`) from topics)')->first();
        if(is_null($max_id))
            $max_id = 1;
        else
            $max_id = $max_id->id+1;

        if($max_id < 10)
            $max_id = '00'.$max_id;
        else if($max_id < 100)
            $max_id = '0'.$max_id;

        $field = Field::whereId($field_id)->first();
        if(is_null($field))
            $field_code = 'NOFIELD';
        else
            $field_code = $field->code;
        return $field_code.'_'.$max_id;
    }
}
