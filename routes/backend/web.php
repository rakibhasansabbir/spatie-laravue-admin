<?php
Route::prefix('role')->group(function () {
    Route::get('','RoleController@index')->name('backend.role.index');
});
