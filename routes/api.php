<?php

use Illuminate\Http\Request;
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
Route::get('/v1/tasks/{task}','Api\TasksController@index');
Route::get('/v1/tasks/','Api\TasksController@show');
Route::delete('/v1/tasks/{task}','Api\TasksController@destroy');
Route::post('/v1/tasks/','Api\TasksController@store');
Route::put('/v1/tasks/{task}','Api\TasksController@edit');

//Route::get('/v1/tasks',function (){
//
//return App\Task::all();
//});
