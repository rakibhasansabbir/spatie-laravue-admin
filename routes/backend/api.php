<?php
Route::prefix('role')->group(function () {
    Route::get('', 'RoleController@indexApi')->name('backend.api.role.index');
    Route::post('', 'RoleController@store')->name('backend.api.role.store');
    Route::put('{roleID}', 'RoleController@update')->name('backend.api.role.update');
    Route::delete('{roleID}', 'RoleController@destroy')->name('backend.api.role.delete');
});
Route::prefix('permission')->group(function () {
    Route::get('', 'PermissionController@indexApi')->name('backend.api.permission.index');
    Route::post('', 'PermissionController@store')->name('backend.api.permission.store');
    Route::put('{roleID}', 'PermissionController@update')->name('backend.api.permission.update');
    Route::delete('{roleID}', 'PermissionController@destroy')->name('backend.api.permission.delete');
});
