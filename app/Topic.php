<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;
use Config;


class Topic extends Model
{
    protected $table = 'topics';

    protected $fillable = [
    	'code',
    	'name',
    	'field_id',
        'is_locked',
    	'description',
    	'created_user_id',
    	'modified_user_id'
    ];


    public function send_email_register(User $student, User $teacher, $accept = 0){

        $email = $student->email;

        $data = array(
                'full_name'=> $student->getFullName(),
                'teacher_full_name' => $teacher->getFullName(),
                'topic_name'=> $this->name
            );
        if($accept == 0)
            $form_email = 'emails.denies_student_register';
        elseif($accept == 1)
            $form_email = 'emails.accept_student_register';
        elseif($accept == 2)
            $form_email = 'emails.denies_student_learn';
        else
            $form_email = 'emails.accept_student_protected';
        Mail::send($form_email, $data, function ($message) use ($email)
        {
            $message->from(Config::get('mail.username'));
            $message->to($email)->subject('[Quản lý khóa luận - Đại học Công Nghệ - ĐHQGHN]- Giảng viên chấp nhận yêu cầu đăng ký');
        });
    }

    /* FUNCTIONS FOR RELATIONSHIP*/

    public function field(){
    	return $this->hasOne(\App\Manager\Field::class, 'id', 'field_id');    
    }

    public function author(){
    	return $this->hasOne(\App\User::class, 'id', 'created_user_id');    	
    }

    public function students_learn(){
        return $this->hasMany(\App\StudentTopic::class, 'current_topic_id', 'id');           
    }

    public function students_register(){
        return $this->hasMany(\App\StudentTopic::class, 'register_topic_id', 'id');           
    }

    public function tutors(){
        return $this->belongsToMany(\App\User::class,'teacher_topic','topic_id','user_id');
    }
}
