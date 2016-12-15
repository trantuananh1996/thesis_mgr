<?php
Route::group(['prefix'=>'cohorts-programs','middleware'=>['auth']],function(){

    Route::get('/config',['as'=>'cohorts-programs', 'uses'=>'Manager\CohortsProgramsController@config']);

	Route::get('/',['as'=>'cohorts-programs', 'uses'=>'Manager\CohortsProgramsController@index']);

	// CRUD cohorts
	Route::post('/add-cohort',['as'=>'cohorts-programs.add-cohort', 'uses'=>'Manager\CohortsProgramsController@addCohort']);

	Route::post('/save-cohort', 'Manager\CohortsProgramsController@saveCohort')->name('cohorts-programs.save-cohort');

    Route::post('/delete-cohort', 'Manager\CohortsProgramsController@deleteCohort')->name('cohorts-programs.delete-cohort');

    // CRUD modules
    Route::post('/add-program',['as'=>'cohorts-programs.add-program', 'uses'=>'Manager\CohortsProgramsController@addProgram']);

	Route::post('/save-program', 'Manager\CohortsProgramsController@saveProgram')->name('cohorts-programs.save-cohort');

    Route::post('/delete-program', 'Manager\CohortsProgramsController@deleteProgram')->name('cohorts-programs.delete-program');

    // routers for connect
    Route::post('/show-cohort-connect-programs','Manager\CohortsProgramsController@show_cohort_connect_programs')->name('cohorts-programs.show-cohort-connect-programs');

    Route::post('/cohort-connect-programs','Manager\CohortsProgramsController@show_cohort_connect_programs')->name('cohorts-programs.cohort-connect-programs');

    // routers for connect students
    Route::post('/show-cohort-students', 'Manager\CohortsProgramsController@cohort_students')->name('cohorts-programs.show-cohort-students');    
    
    Route::post('/cohort-connect-students', 'Manager\CohortsProgramsController@cohort_students')->name('cohorts-programs.cohort-connect-students');    
});