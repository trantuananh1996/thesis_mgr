<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Program extends Model
{
    protected $table = 'education_programs';

    protected $fillable = [
    	'code',
    	'name',
        'unit_id',
    	'description',
    	'created_user_id',
    	'modified_user_id'
    ];

    public function store($data){
		return $this->create([
			'name'=>$data['name'],
			'code'=>$data['code'],
            'unit_id'=>$data['unit_id'],
			'description'=>'',
			'created_user_id'=>Auth::user()->id,
			'modified_user_id'=>Auth::user()->id,
			]);
	}

    public function cohorts(){
        return $this->belongsToMany(\App\Cohort::class,'cohort_program','program_id','cohort_id')->withTimestamps();
    }

    public function unit(){
        return $this->hasOne(\App\Manager\Unit::class, 'id', 'unit_id');
    }
}
