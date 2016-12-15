<?php
Route::group(['prefix' => 'terms', 'middleware' => ['auth']], function () {

    Route::get('/', ['as' => 'terms', 'uses' => 'Manager\TermsController@index']);

    Route::post('/create', ['as' => 'terms.create', 'uses' => 'Manager\TermsController@create']);

    Route::post('/update', ['as' => 'terms.update', 'uses' => 'Manager\TermsController@update']);

    Route::post('/delete', ['as' => 'terms.delete', 'uses' => 'Manager\TermsController@delete']);
    Route::get('/show/{code}', ['as' => 'terms.show', 'uses' => 'Manager\TermsController@show']);
    Route::post('/upload-students', ['as' => 'terms.upload', 'uses' => 'Manager\TermsController@validateUpload']);
    Route::post('/show/show-student-connect-term', ['as' => 'terms.show-student-connect', 'uses' => 'Manager\TermsController@showConnectStudents']);
    Route::post('/show/reload-student-connect', ['as' => 'terms.reload-student-connect', 'uses' => 'Manager\TermsController@reloadConnectStudents']);
    Route::post('/show/email-to-student', ['as' => 'terms.email-to-student', 'uses' => 'Manager\TermsController@sendEmailToStudents']);
});