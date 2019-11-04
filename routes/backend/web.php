<?php
Route::group(['middleware' => ['permission:admin_dashboard']], function () {
    Route::get('/', function () {
        return view('backend.dashboard');
    });
});
Route::group(['middleware' => ['permission:role_index']], function () {
    Route::get('role', 'RoleController@index')->name('backend.role.index');
});
Route::group(['middleware' => ['permission:permission_index']], function () {
    Route::get('permission', 'PermissionController@index')->name('backend.permission.index');
});
Route::group(['middleware' => ['permission:user_index']], function () {
    Route::get('user', 'UserController@index')->name('backend.user.index');
});
