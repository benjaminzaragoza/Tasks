<?php

namespace App\Http\Controllers;
use App\Http\Requests\IndexUserTask;
use App\Tag;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\ShowTask;

use Illuminate\Support\Facades\Auth;

class TasquesController extends Controller
{
    public function index(IndexUserTask $request)
    {
        if (Auth::user()->can('tasks.manage')) {
            $tasks =  map_collection(Task::with('user','tags')->orderBy('created_at','desc')->get());
            $uri = '/api/v1/tasks';
        }else{
            $tasks= map_collection($request->user()->tasks);
            $uri = '/api/v1/user/tasks';
        }
        // Agafa de la base de dades i ho passa a la vista
        $users = map_simple_collection(User::with('roles','permissions')->get());
        $tags = map_collection(Tag::all());
        Cache::rememberForever(Task::TASKS_CACHE_KEY, function () {
            if (Auth::user()->can('tasks.manage')) {
                return $tasks = map_collection(Task::with('user', 'tags')->orderBy('created_at', 'desc')->get());
            } else {
                return $tasks = map_collection(Auth::user()->tasks);
            }
        });
        return view('tasques',compact('tasks','users','uri','tags'));
    }

    public function show(ShowTask $request)
    {
        $task = map_collection(Task::where('id', '=', $request->id )->with('user')->first());
        $users = map_collection(User::with('roles','permissions')->get());
        return view('tasks.user.show', compact('task', 'users'));
    }
}
