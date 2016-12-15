<?php

Route::group(['prefix' => 'field', 'middleware' => 'auth'], function () {
    //CRUD
    Route::get('/', 'Manager\FieldController@index')->name('field.index');
    Route::get('/create', 'Manager\FieldController@create')->name('field.create');
    Route::get('/show/{slug}', 'Manager\FieldController@show')->name('field.show');
    Route::get('/edit/{slug}', 'Manager\FieldController@edit')->name('field.edit');
    Route::put('/field/{slug}', 'Manager\FieldController@update')->name('field.update');
    Route::post('/', 'Manager\FieldController@store')->name('field.store');
    Route::get('/{field}/destroy', 'Manager\FieldController@destroy')->name('field.destroy');
    //Connect
    Route::post('/show-teacher-connect-field','Manager\FieldController@connectTeacher');
    Route::post('/teacher-connect-field','Manager\FieldController@connectTeacher');
});
