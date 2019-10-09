<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('backend.welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// //================= Role Routes ============================
// Route::group(['prefix'=>'role','middleware'=>'auth'],function(){
//     Route::get('/index','Backend\RoleController@index')->name('role.index');
//     Route::get('/create','RoleController@create')->name('role.create')->middleware(['permission:can_create_role']);
//     Route::post('/store','RoleController@store')->name('role.store')->middleware(['permission:can_create_role']);
//     Route::get('/{id}/edit','RoleController@edit')->name('role.edit')->middleware(['permission:can_update_role']);
//     Route::post('/{id}/update','RoleController@update')->name('role.update')->middleware(['permission:can_update_role']);
//     Route::get('/{id}/delete','RoleController@delete')->name('role.delete')->middleware(['permission:can_delete_role']);
// });
// //================= User Routes ============================
// Route::group(['prefix'=>'user','middleware'=>'auth'],function(){
//     Route::get('/request-users','UserController@requestUser')->name('request.user')->middleware(['permission:can_approve_user']);
//     Route::get('/request-users/{id}/view','UserController@requestUserView')->name('request.user.view')->middleware(['permission:can_approve_user']);
//     Route::get('/request-users/{id}/accept','UserController@requestUserAccept')->name('request.user.accept')->middleware(['permission:can_approve_user']);
//     Route::get('/profile','UserController@profile')->name('profile');
//     Route::get('/profile/edit','UserController@profileEdit')->name('profile.edit');
//     Route::post('/profile/edit','UserController@profileUpdate')->name('profile.update');
//     Route::get('/index','UserController@index')->name('user.index')->middleware(['permission:user']);
//     Route::get('/create','UserController@create')->name('user.create')->middleware(['permission:can_create_user']);
//     Route::post('/store','UserController@store')->name('user.store')->middleware(['permission:can_create_user']);
//     Route::get('/{id}/show','UserController@show')->name('user.show')->middleware(['permission:user']);
//     Route::get('/{id}/edit','UserController@edit')->name('user.edit')->middleware(['permission:can_update_user']);
//     Route::post('/{id}/update','UserController@update')->name('user.update')->middleware(['permission:can_update_user']);
//     Route::get('/{id}/delete','UserController@delete')->name('user.delete')->middleware(['permission:can_delete_user']);
// });
// //================= Permission Routes ============================
// Route::group(['prefix'=>'permission','middleware'=>'auth'],function(){
//     Route::get('/index','PermissionController@index')->name('permission.index')->middleware(['permission:permission']);
//     Route::get('/create','PermissionController@create')->name('permission.create')->middleware(['permission:can_create_permission']);
//     Route::post('/store','PermissionController@store')->name('permission.store')->middleware(['permission:can_create_permission']);
//     Route::get('/{id}/edit','PermissionController@edit')->name('permission.edit')->middleware(['permission:can_update_permission']);
//     Route::post('/{id}/update','PermissionController@update')->name('permission.update')->middleware(['permission:can_update_permission']);
//     Route::get('/{id}/delete','PermissionController@delete')->name('permission.delete')->middleware(['permission:can_delete_permission']);
// });
