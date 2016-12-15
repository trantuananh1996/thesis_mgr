<?php

namespace App\Http\Controllers;

use Auth;
use Gate;
use App\Topic;

use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function __construct(){

    }

    public function index(){
        if(Gate::allows('topics_manage'))
            return redirect('manager/topics');

    	if(Gate::allows('topics_teacher'))
    		return redirect('teacher/topics');

        if(Gate::allows('topics_student'))
            return redirect('student/topics');

    	return redirect(redirect()->getUrlGenerator()->previous())
    			->withErrors('Không có quyền truy cập vào trang này');
    }

    public function info($topic){
    	$topic = Topic::whereCode($topic)->first();

    	if(is_null($topic))
    		return redirect(redirect()->getUrlGenerator()->previous())
    			->withErrors('Không tìm thấy đề tài khóa luận này');

        if(Gate::allows('topics_manage'))
            return redirect('manager/topics/'.$topic->code.'/info');

    	if(Gate::allows('topics_teacher')){
            if(Auth::user()->id == $topic->created_user_id)
               return redirect('teacher/topics/'.$topic->code.'/edit');
            else
                return redirect('teacher/topics/'.$topic->code.'/info');
        }

        if(Gate::allows('topics_student'))
            return redirect('student/topics/'.$topic->code.'/info');

    	return redirect(redirect()->getUrlGenerator()->previous())
    			->withErrors('Không có quyền truy cập vào trang này');
    }
}
