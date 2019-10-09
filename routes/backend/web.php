<?php
Route::prefix('role')->namespace('Roles')->group(function () {
    Route::get('','RoleController@index')->name('roles.index');
});
