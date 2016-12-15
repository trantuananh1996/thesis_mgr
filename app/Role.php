<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Role extends Model
{
    protected $table = 'roles';

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

    public function permissions(){
    	return $this->belongsToMany(\App\Permission::class,'role_permission','role_id','permission_id')->withTimestamps();
    }

    public function assignModuleTo (Permission $permission)
	{
		return $this->permission()->save($permission);
	}

	public function users(){
		return $this->belongsToMany(\App\User::class,'role_user','role_id','user_id')->withTimestamps();	
	}
}
