<?php

namespace App\Http\Controllers\Api;
use App\Events\TaskStored;
use App\Events\TaskUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyUserTask;
use App\Http\Requests\IndexUserTask;
use App\Http\Requests\StoreUserTask;
use App\Http\Requests\UpdateUserTask;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggedUserTasksController extends Controller
{
    public function index(IndexUserTask $request)
    {
        return Auth::user()->tasks;

    }
    public function store(StoreUserTask $request)
    {
        $task = Task::create($request->only(['name','completed','description','user_id']));
        Auth::user()->addTask($task);
        event(new TaskStored($task,Auth::user()));
        return $task->map();
    }

    public function update(UpdateUserTask $request, Task $task)
    {
//        findOrFail
        Auth::user()->tasks()->findOrFail($task->id);
        $task_old=$task;
        $task->name = $request->name;
        $task->description = $request->description;
        $task->completed = $request->completed;
        $task->save();
        event(new TaskUpdate($task_old,$task,Auth::user()));
        return $task->map();

    }
    public function destroy(DestroyUserTask $request, Task $task)
    {
        Auth::user()->tasks()->findOrFail($task->id);
        $task->delete();
    }
}
