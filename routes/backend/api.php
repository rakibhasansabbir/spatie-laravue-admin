<?php
Route::prefix('role')->group(function () {
    Route::get('', 'RoleController@indexApi')->name('backend.api.role.index');
    Route::post('', 'RoleController@store')->name('backend.api.role.store');
    Route::delete('{roleID}', 'RoleController@destroy')->name('backend.api.role.delete');
});
