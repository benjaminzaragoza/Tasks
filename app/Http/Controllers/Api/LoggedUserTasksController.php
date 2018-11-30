<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyUserTask;
use App\Http\Requests\IndexUserTask;
use App\Http\Requests\StoreUserTask;
use App\Http\Requests\UpdateUserTask;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggedUserTasksController extends Controller
{
    public function index(IndexUserTask $request)
    {
//        return Auth::user()->tasks;
        return map_collection($request->user()->tasks);

    }
    public function store(StoreUserTask $request)
    {
        $task=Request::create($request->only(['name','completed']));
        return Auth::user()->addTask($task);

    }

    public function update(UpdateUserTask $request, Task $task)
    {
//        findOrFail
        Auth::user()->tasks()->findOrFail($task->id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->completed = $request->completed;
        $task->save();
        return $task;

    }
    public function destroy(DestroyUserTask $request, Task $task)
    {
        Auth::user()->tasks()->findOrFail($task->id);
        $task->delete();
//        $user->removeTask();
    }
}
