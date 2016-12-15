<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;
use Carbon\Carbon;

use Auth;
use Validator;

class UsersController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function checkAccount(Request $request){
		$data = $request->all();
		if(isset($data['username']))
			$user = User::whereUsername($data['username'])->first();
		else if(isset($data['email']))
			$user = User::whereEmail($data['email'])->first();
		if(!is_null($user))
			return response()->json([
					"valid"=> false
				]);
		return response()->json([
					"valid"=> true
				]);
	}
}
