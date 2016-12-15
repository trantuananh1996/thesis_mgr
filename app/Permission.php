<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
    	'name',
    	'code',
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

    public function roles(){
        return $this->belongsToMany(\App\Role::class,'role_permission','permission_id','role_id')->withTimestamps();
    }
}
