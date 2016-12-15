<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index');
Route::get('/logout','Auth\LoginController@logout');
Route::get('/profile','HomeController@show_profile');
Route::post('/profile','HomeController@update_profile');

// router for account
Route::get('/active/{token}/{user}','Auth\LoginController@active');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::post('/checkAccount', 'Manager\UsersController@checkAccount');
Route::get('/404', function(){
	return view('pages.404');
});

require(__DIR__ . '/SuperManager/roles-permissions.php');

require(__DIR__ . '/Manager/users.php');
require(__DIR__ . '/Manager/unit.php');
require(__DIR__ . '/Manager/field.php');
require(__DIR__ . '/Manager/cohorts-programs.php');
require(__DIR__ . '/Manager/terms.php');

require(__DIR__ . '/Teacher/topics.php');
require(__DIR__ . '/General/topics.php');
require(__DIR__ . '/Student/topics.php');

