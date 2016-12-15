<?php
Route::group(['prefix' => '/roles-permissions', 'middleware' => ['auth']], function ()
{

	Route::get('/', ['as' => 'roles-permissions', 'uses' => 'SuperManager\RolesPermissionsController@index']);

	// CRUD roles
	Route::post('/add-role', ['as' => 'roles-permissions.add-role', 'uses' => 'SuperManager\RolesPermissionsController@addRole']);

	Route::post('/save-role', 'SuperManager\RolesPermissionsController@saveRole')
		->name('roles-permissions.save-role');

	Route::post('/delete-role', 'SuperManager\RolesPermissionsController@deleteRole')
		->name('roles-permissions.delete-role');

	// CRUD modules
	Route::post('/add-permission', ['as' => 'roles-permissions.add-permission', 'uses' => 'SuperManager\RolesPermissionsController@addPermission']);

	Route::post('/save-permission', 'SuperManager\RolesPermissionsController@savePermission')
		->name('roles-permissions.save-role');

	Route::post('/delete-permission', 'SuperManager\RolesPermissionsController@deletePermission')
		->name('roles-permissions.delete-permission');

	Route::post('/show-role-connect-permissions', 'SuperManager\RolesPermissionsController@show_role_connect_permissions')
		->name('roles-permissions.show-role-connect-permissions');

	Route::post('/role-connect-permissions', 'SuperManager\RolesPermissionsController@show_role_connect_permissions')
		->name('roles-permissions.role-connect-permissions');

	Route::post('/show-permission-connect-roles', 'SuperManager\RolesPermissionsController@show_permission_connect_roles')
		->name('roles-permissions.show-permission-connect-roles');

	Route::post('/permission-connect-roles', 'SuperManager\RolesPermissionsController@show_permission_connect_roles')
		->name('roles-permissions.permission-connect-roles');
});