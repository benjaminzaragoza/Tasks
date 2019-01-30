<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\LoggedUserAvatarController;
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
    Route::post('/avatar', '\\'. AvatarController::class . '@store');
    Route::get('/user/photo', '\\'. LoggedUserPhotoController::class . '@show');
    Route::get('/user/avatar', '\\'. LoggedUserAvatarController::class . '@show');

    Route::get('/changelog','\\'. ChangelogController::class . '@index');

});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth/{provider}', '\\'. LoginController::class . '@redirectToProvider');
Route::get('/auth/{provider}/callback', '\\'. LoginController::class . '@handleProviderCallback');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/prova_cua', function(){
    \App\Jobs\SleepJob::dispatch();
});