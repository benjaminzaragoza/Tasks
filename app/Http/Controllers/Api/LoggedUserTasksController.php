<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyLoggedUserTask;
use App\Http\Requests\IndexLoggedUserTask;
use App\Http\Requests\StoreLoggedUserTask;
use App\Http\Requests\UpdateLoggedUserTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggedUserTasksController extends Controller
{
    public function index(IndexLoggedUserTask $request)
    {
//        return Auth::user()->tasks;
        return map_collection($request->user()->tasks);

    }
    public function store(StoreLoggedUserTask $request)
    {
        $task=Request::create($request->only(['name','completed']));
        return Auth::user()->addTask($task);

    }

    public function update(UpdateLoggedUserTask $request,Task $task)
    {
//        findOrFail
        Auth::user()->tasks()->findOrFail($task->id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->completed = $request->completed;
        $task->save();
        return $task;

    }
    public function destroy(DestroyLoggedUserTask $request,Task $task)
    {
        Auth::user()->tasks()->findOrFail($task->id);
        $task->delete();
//        $user->removeTask();
    }
}
