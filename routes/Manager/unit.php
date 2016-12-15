<?php

Route::group(['prefix' => 'unit', 'middleware' => 'auth'], function () {
    //CRUD
	Route::get('/', 'Manager\UnitController@index')->name('unit.index');
	Route::get('/create', 'Manager\UnitController@create')->name('unit.create');
	Route::get('/show/{slug}', 'Manager\UnitController@show')->name('unit.show');
	Route::get('/edit/{slug}', 'Manager\UnitController@edit')->name('unit.edit');
	Route::put('/unit/{slug}', 'Manager\UnitController@update')->name('unit.update');
	Route::post('/', 'Manager\UnitController@store')->name('unit.store');
	Route::get('/{slug}/destroy', 'Manager\UnitController@destroy')->name('unit.destroy');
    //Connect
    Route::post('/show-teacher-connect-unit','Manager\UnitController@connectTeacher');
    Route::post('/teacher-connect-unit','Manager\UnitController@connectTeacher');
});

