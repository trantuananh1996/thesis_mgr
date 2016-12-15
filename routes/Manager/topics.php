<?php
Route::group(['prefix' => 'manager/topics', 'middleware' => ['auth']], function (){

	Route::get('/', ['as' => 'manager.topics', 'uses' => 'Manager\TopicsController@index']);

	Route::get('/{topic}/info', ['as' => 'manager.topics.info', 'uses' => 'Manager\TopicsController@info']);

	Route::post('/change-locked', ['as' => 'manager.topics.change-locked', 'uses' => 'Manager\TopicsController@change_locked']);

	Route::post('/delete', ['as' => 'manager.topics.delete', 'uses' => 'Manager\TopicsController@delete']);

	Route::post('/denies-student-learn', ['as' => 'manager.topics.denies-student-learn', 'uses' => 'Manager\TopicsController@denies_student_learn']);	

	Route::post('/{topic}/denies-student-learn', ['as' => 'manager.topics.denies-student-learn', 'uses' => 'Manager\TopicsController@denies_student_learn']);	

	Route::post('/{topic}/accept-student-protected', ['as' => 'manager.topics.accept-student-protected', 'uses' => 'Manager\TopicsController@accept_student_protected']);	
});