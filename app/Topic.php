<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
