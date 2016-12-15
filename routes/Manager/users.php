<?php
Route::group(['prefix'=>'users','middleware'=>['auth']],function(){

	// router for teachers
	Route::group(['prefix'=>'/teachers'],function(){
		Route::get('/','Manager\Users\TeachersController@index')->name('teachers');

		Route::post('/create','Manager\Users\TeachersController@create')->name('teachers.create');

		Route::post('/edit','Manager\Users\TeachersController@edit')->name('teachers.edit');

		Route::post('/update','Manager\Users\TeachersController@update')->name('teachers.update');

		Route::post('/delete','Manager\Users\TeachersController@delete')->name('teachers.delete');

        Route::post('/upload','Manager\Users\TeachersController@validateUpload')->name('teachers.upload');
	});

	// router for students
	Route::group(['prefix'=>'/students'],function(){

		Route::get('/','Manager\Users\StudentsController@index')->name('students');

		Route::post('/create','Manager\Users\StudentsController@create')->name('students.create');

		Route::post('/edit','Manager\Users\StudentsController@edit')->name('students.edit');

		Route::post('/update','Manager\Users\StudentsController@update')->name('students.update');

        Route::post('/delete','Manager\Users\StudentsController@delete')->name('students.delete');

        Route::post('/upload','Manager\Users\StudentsController@validateUpload')->name('students.upload');

    });


});