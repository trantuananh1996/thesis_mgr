<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Cohort extends Model
{
    protected $table = 'cohorts';

    protected $fillable = [
    	'code',
    	'name',
    	'description',
    	'created_user_id',
    	'modified_user_id'
    ];

    public function store($data){
		return $this->create([
			'name'=>$data['name'],
			'code'=>$data['code'],
			'description'=>'',
			'created_user_id'=>Auth::user()->id,
			'modified_user_id'=>Auth::user()->id,
			]);
	}

    /* ------- FUNCTIONS FOR RELATIONSHIP ----------*/

    public function programs(){
        return $this->belongsToMany(\App\Program::class,'cohort_program','cohort_id','program_id')->withTimestamps();
    }

    public function assignProgramTo (Program $program)
    {
        return $this->programs()->save($program);
    }

    public function users(){
        // return $this->belongsToMany(\App\User::class,'role_user','role_id','user_id')->withTimestamps();    
    }
}
