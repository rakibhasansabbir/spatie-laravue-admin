<?php
Route::get('/', function () {
    return view('backend.dashboard');
});
Route::prefix('role')->group(function () {
    Route::get('','RoleController@index')->name('backend.role.index');
});
Route::prefix('permission')->group(function () {
    Route::get('','PermissionController@index')->name('backend.permission.index');
});
Route::prefix('user')->group(function () {
    Route::get('','UserController@index')->name('backend.user.index');
});
