<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

class StudentTopic extends Model
{
    protected $table = 'student_topic';

    protected $fillable = [
    	'student_id',
    	'current_topic_id',
    	'register_topic_id',
    	'status',
    	'can_register',
    	'point',
    	'teacher_id',
    	'teacher_accepted',
    	'reviewer_id'
    ];

    
    public static function create_empty($student_id,$can_register = 0){
    	return StudentTopic::create(['student_id'=>$student_id,'can_register'=>$can_register]);
    }

    public function change_status(){
        $current = $this->current_topic_id;
        $register = $this->register_topic_id;
        $teacher_accepted = $this->teacher_accepted;

        if($current == 0 && $register == 0)
            $this->status = 0;
        else if($current != 0 && $register == 0 && $teacher_accepted == 1)
            $this->status = 2;
        else if($register !=0 && $teacher_accepted == 0)
            $this->status = 1;
        $this->save();
        return $this;
    }

    public function get_status(){
        switch ($this->status) {
            case 0:
                return 'Chưa đăng ký';
                break;
            case 1:
                return 'Đã đăng ký, đang đợi phản hồi';
                break;
            case 2:
                return 'Giảng viên đồng ý';
                break;
            case 3:
                return 'Được bảo vệ khóa luận';
                break;
            case 4:
                return 'Bảo vệ khóa luận thành công';
                break;
            default:
                return 'Chưa đăng ký';
                break;
        }
    }

    /* FUNCTIONS FOR RELATIONSHIP */

    public function student(){
    	return $this->hasOne(\App\User::class, 'id', 'student_id');    
    }

    public function current_topic(){
    	return $this->hasOne(\App\Topic::class, 'id', 'current_topic_id');    	
    }

    public function register_topic(){
    	return $this->hasOne(\App\Topic::class, 'id', 'register_topic_id');    		
    }

    public function teacher(){
    	return $this->hasOne(\App\User::class, 'id', 'teacher_id');    			
    }

    public function reviewer(){
    	return $this->hasOne(\App\User::class, 'id', 'reviewer_id');    				
    }


}
