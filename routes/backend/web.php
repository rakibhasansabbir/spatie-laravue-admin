<?php
Route::prefix('role')->group(function () {
    Route::get('','RoleController@index')->name('backend.role.index');
});
Route::prefix('permission')->group(function () {
    Route::get('','PermissionController@index')->name('backend.permission.index');
});
