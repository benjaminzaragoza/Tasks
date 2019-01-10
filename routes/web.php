<?php

use App\Http\Controllers\LoggedUserPhotoController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

//TODO
Route::post('login_alt','Auth\LoginAltController@login');
//Route::post('/register_alt', 'Auth\RegisterAltController@store');
Route::post('/register_alt','Auth\RegisterAltController@register');

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
    Route::get('/tasques','TasquesController@index');

    Route::get('/home','TasquesController@index');
    Route::get('/user/tasks','LoggedUserTasksController@index');

    Route::impersonate();
    Route::get('/tags', 'TagsController@index');
    Route::get('/profile', '\\'. ProfileController::class . '@show');
    Route::post('/photo', '\\'. PhotoController::class . '@store');
    Route::get('/user/photo', '\\'. LoggedUserPhotoController::class . '@show');


});
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
