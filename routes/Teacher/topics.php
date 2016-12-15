<?php
Route::group(['prefix' => 'teacher/topics', 'middleware' => ['auth']], function (){

	Route::get('/', ['as' => 'teacher.topics', 'uses' => 'Teacher\TopicsController@index']);

	Route::get('/create', ['as' => 'teacher.topics.create', 'uses' => 'Teacher\TopicsController@create']);

	Route::post('/create', ['as' => 'teacher.topics.store', 'uses' => 'Teacher\TopicsController@store']);

	Route::get('/{topic}/edit', ['as' => 'teacher.topics.edit', 'uses' => 'Teacher\TopicsController@edit']);

	Route::post('/{topic}/update', ['as' => 'teacher.topics.update', 'uses' => 'Teacher\TopicsController@update']);

	Route::post('/delete', ['as' => 'teacher.topics.delete', 'uses' => 'Teacher\TopicsController@delete']);

	Route::post('/change-locked', ['as' => 'teacher.topics.change-locked', 'uses' => 'Teacher\TopicsController@change_locked']);

	Route::post('/show-connect-tutors', ['as' => 'teacher.topics.show-connect-tutors', 'uses' => 'Teacher\TopicsController@connect_tutors']);

	Route::post('/connect-tutors', ['as' => 'teacher.topics.connect-tutors', 'uses' => 'Teacher\TopicsController@connect_tutors']);

	Route::get('/{topic}/info', ['as' => 'teacher.topics.info', 'uses' => 'Teacher\TopicsController@info']);

	Route::post('/show-students-register', ['as' => 'teacher.topics.show-students-register', 'uses' => 'Teacher\TopicsController@show_students_register']);

	Route::post('/accept_student_register', ['as' => 'teacher.topics.accept_student_register', 'uses' => 'Teacher\TopicsController@accept_student_register']);

	Route::post('/denies_student_register', ['as' => 'teacher.topics.denies_student_register', 'uses' => 'Teacher\TopicsController@denies_student_register']);
	
});