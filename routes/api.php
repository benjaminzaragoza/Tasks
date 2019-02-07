<?php

use App\Http\Controllers\Api\GitController;
use App\Http\Controllers\Api\TasksTagsController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\PhotoController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Changelog\ChangelogController;
use App\Http\Controllers\Api\Notifications\NotificationsController;
use App\Http\Controllers\Api\Notifications\SimpleNotificationsController;
use App\Http\Controllers\Api\Notifications\UserNotificationsController;
use App\Http\Controllers\Api\Notifications\UserUnreadNotificationsController;
use App\Task;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function (){
    Route::get('/v1/tasks','Api\TasksController@index');                // BROWSE - llista
    Route::get('/v1/tasks/{task}','Api\TasksController@show');          // READ
    Route::delete('/v1/tasks/{task}','Api\TasksController@destroy');    // DELETE
    Route::post('/v1/tasks','Api\TasksController@store');               // CREATE
    Route::put('/v1/tasks/{task}','Api\TasksController@update');         // EDIT

    Route::delete('/v1/completed_task/{task}','Api\CompletedTasksController@destroy');         // EDIT
    Route::post('/v1/completed_task/{task}','Api\CompletedTasksController@store');         // EDIT


Route::get('/v1/tags', 'Api\TagsController@index');
Route::post('/v1/tags', 'Api\TagsController@store');
Route::get('/v1/tags/{tag}', 'Api\TagsController@show');
Route::put('/v1/tags/{tag}', 'Api\TagsController@update');
Route::delete('/v1/tags/{tag}', 'Api\TagsController@destroy');

Route::get('/v1/user/tasks','Api\LoggedUserTasksController@index');//Route::get('/v1/tasks',function (){
Route::get('/v1/user/tasks/{task}','Api\LoggedUserTasksController@show');//Route::get('/v1/tasks',function (){
Route::post('/v1/user/tasks/','Api\LoggedUserTasksController@store');//Route::get('/v1/tasks',function (){
Route::put('/v1/user/tasks/{task}','Api\LoggedUserTasksController@update');//Route::get('/v1/tasks',function (){
Route::delete('/v1/user/tasks/{task}','Api\LoggedUserTasksController@destroy');//Route::get('/v1/tasks',function (){

Route::get('/v1/users','Api\UsersController@index');
Route::get('/v1/regular_users','Api\RegularUsersController@index');

Route::put('/v1/tasks/{task}/tags','\\'. TasksTagsController::class.'@update');

Route::post('/v1/tasks/{task}/tag', 'Api\TaskTagController@store');
Route::delete('/v1/tasks/{task}/tag', 'Api\TaskTagController@destroy');

Route::get('/v1/git/info','\\' . GitController::class . '@index');
Route::get('/v1/changelog','\\' . ChangelogController::class . '@index');

    Route::post('/v1/user/photo', '\\' . PhotoController::class . '@store');
    Route::post('/v1/user/avatar', '\\' . AvatarController::class . '@store');

    // Notifications
    Route::get('/v1/notifications','\\' . NotificationsController::class . '@index');
    Route::post('/v1/notifications/multiple','\\' . NotificationsController::class . '@destroyMultiple');
    Route::delete('/v1/notifications/{notification}','\\' . NotificationsController::class . '@destroy');
    Route::get('/v1/user/notifications','\\' . UserNotificationsController::class . '@index');
    Route::get('/v1/user/unread_notifications','\\' . UserUnreadNotificationsController::class . '@index');
    Route::delete('/v1/user/unread_notifications/all','\\' . UserUnreadNotificationsController::class . '@destroyAll');
    Route::delete('/v1/user/unread_notifications/{notification}','\\' . UserUnreadNotificationsController::class . '@destroy');
    // Simple notifications
    Route::post('/v1/simple_notifications/','\\' . SimpleNotificationsController::class . '@store');
});
//
//return App\Task::all();
//});
