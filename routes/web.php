<?php

use Illuminate\Support\Facades\Auth;

Auth::routes();

//TODO
Route::post('login_alt','Auth\LoginAltController@login');
Route::post('/register_alt', 'Auth\RegisterAltController@store');

//middleware
Route::middleware(['auth'])->group(function (){
Route::get('/tasks','TasksController@index');
Route::post('/tasks','TasksController@store');
Route::delete('/tasks/{id}','TasksController@destroy');
Route::put('/tasks/{id}','TasksController@update');
Route::get('/task_edit/{id}','TasksController@edit');
Route::get('/about',function(){
        return view('/about');
});
Route::view('/contact','contact');
Route::post('/completed_task/{task}','TasksCompletedController@store');
Route::delete('/completed_task/{task}','TasksCompletedController@destroy');
Route::get('/tasks_vue','TasksVueController@index');
Route::get('/home','TasksVueController@index');
});



Route::get('/', function () {
    return view('welcome');
});





Route::get('/tags', 'TagController@index');


