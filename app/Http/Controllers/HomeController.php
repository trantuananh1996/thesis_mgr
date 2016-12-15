<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use Session;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function show_profile(){
        $user = Auth::user();
        return view('pages.profile',compact('user'));
    }

    public function update_profile(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'password'  => 'min:6|confirmed',
            'password_confirmation' => 'same:password',
            'dob'       => 'required',
            'gender'    => 'numeric|required',
            'fullName'  => 'required'
        ]);

        if ($validator->fails())
            return redirect(redirect()->getUrlGenerator()->previous())
                ->withErrors($validator)->withInput();

        if(isset($data['password']) && $data['password']!= ''){
            if(!isset($data['old_password']))
                return redirect(redirect()->getUrlGenerator()->previous())->withErrors('Chưa nhập mật khẩu cũ.')->withInput();                

            if (!Hash::check($data['old_password'], Auth::user()->password))
                return redirect(redirect()->getUrlGenerator()->previous())->withErrors('Mật khẩu cũ chưa chính xác.')->withInput();                
        }

        Auth::user()->updateProfile($data);

        Session::flash('message','Cập nhật thông tin thành công');
        return redirect('/profile');                
    }
}
