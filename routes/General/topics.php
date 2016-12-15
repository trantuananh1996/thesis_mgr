<?php
Route::group(['prefix' => 'topics', 'middleware' => ['auth']], function (){
	Route::get('/', ['as' => 'topics', 'uses' => 'TopicsController@index']);

	Route::get('/{topic}/info',['as' => 'topics.info', 'uses' => 'TopicsController@info']);
});