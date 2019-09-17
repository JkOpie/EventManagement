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


Route::get('/','FrontController@show_event');
Route::get('/website/event/{id}', 'FrontController@event_list');

Auth::routes();

//AdminRunner
Route::get('/runner', 'RunnerController@showrunner')->name('runner');
Route::get('/runner/create', 'RunnerController@create')->name('runner_create');
Route::post('/runner/create', 'RunnerController@store')->name('runner_store');
Route::get('/runner/edit/{id}', 'RunnerController@edit')->name('runner_edit');
Route::post('/runner/edit/{id}', 'RunnerController@update')->name('runner_update');
Route::post('/runner', 'RunnerController@delete')->name('runner_delete');
Route::get('/runner/admin/{id}', 'RunnerController@profile_admin')->name('runner_admin_edit');
Route::post('/runner/admin/{id}', 'RunnerController@update_admin')->name('runner_admin_update');

//AdminEvent
Route::get('/event', 'EventController@index')->name('event');
Route::post('/event', 'EventController@delete')->name('event_delete');
Route::get('/event/{event_id}', 'EventController@show_event_runner')->name('event_show_event_runner');
Route::post('/event/{event_id}', 'EventController@show_event_runner')->name('event_show_event_runner');
Route::get('/event/create/1', 'EventController@register');
Route::post('/event/create/2', 'EventController@create')->name('event_create');
Route::get('/event/edit/{id}', 'EventController@edit')->name('event_edit');
Route::post('/event/edit/{id}', 'EventController@update')->name('event_update');

//user routes
Route::get('/userdash', 'UserController@index')->name('userdash');
Route::post('/userdash', 'UserController@event_register')->name('user_event_register');
Route::post('/userdash/unregister', 'UserController@unregister')->name('user_unregister');
Route::get('/userhistory', 'UserController@get_history')->name('user_get_history');

//userprofile
Route::get('/userprofile', 'UserController@showuser')->name('userpro');
Route::get('/userprofile/edit/{id}' , 'UserController@edit')->name('userpro_edit');
Route::post('/userprofile/edit/{id}' , 'UserController@update')->name('userpro_update');
