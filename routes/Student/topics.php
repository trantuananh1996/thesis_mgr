<?php
Route::group(['prefix' => 'student/topics', 'middleware' => ['auth']], function (){

	Route::get('/', ['as' => 'student.topics', 'uses' => 'Student\TopicsController@index']);

	Route::get('/{topic}/info', ['as' => 'student.topics.info', 'uses' => 'Student\TopicsController@info']);

	Route::post('/register', ['as' => 'student.topics.register', 'uses' => 'Student\TopicsController@register']);	

});