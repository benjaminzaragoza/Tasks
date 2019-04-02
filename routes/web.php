<?php

use App\Http\Controllers\ClockController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\FunctionsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LoggedUserAvatarController;
use App\Http\Controllers\LoggedUserPhotoController;
use App\Http\Controllers\NewslettersController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserPhotoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasquesController;
use App\Http\Controllers\UsersController;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::bind('hashuser', function($value, $route)
{
    $hashids = new Hashids\Hashids(config('scool.salt'));
    $id = $hashids->decode($value)[0];
    return User::findOrFail($id);
});

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
    Route::get('/notifications', '\\' . NotificationController::class . '@index');
    Route::get('/functions','\\'. FunctionsController::class . '@index');

    Route::get('/newsletters', '\\' . NewslettersController::class . '@index');
    Route::get('/clock','\\'. ClockController::class.'@index');
    Route::get('/chat', '\\' . ChatController::class . '@index');
    Route::get('/users', '\\' . UsersController::class . '@index');
    Route::get('/game', '\\' . GameController::class . '@index');
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/auth/{provider}', '\\'. LoginController::class . '@redirectToProvider');
Route::get('/auth/{provider}/callback', '\\'. LoginController::class . '@handleProviderCallback');

Route::get('/user/{hashuser}/photo','\\' . UserPhotoController::class . '@show')->name('user.photo.show');
Route::get('/user/{hashuser}/photo/download', '\\' . UserPhotoController::class . '@download')->name('user.photo.download');
Route::get('/tasques/{id}', '\\' . TasquesController::class . '@show');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/prova_cua', function(){
    \App\Jobs\SleepJob::dispatch();
});
Route::get('/omplir', function(){
    //10 000
    for ($i=0;$i<=1000;$i++) {
        Task::create([
            'name'=>'Prova'
        ]);
    }
});
