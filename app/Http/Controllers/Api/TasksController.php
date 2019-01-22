<?php
namespace App\Http\Controllers\Api;
use App\Events\TaskDelete;
use App\Events\TaskUpdate;
use App\Events\TaskStored;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTask;
use App\Http\Requests\DestroyTask;
use App\Http\Requests\IndexTask;
use App\Http\Requests\ShowTask;
use App\Http\Requests\UpdateTask;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class TasksController extends Controller
{
    public function index(IndexTask $request)
    {
        return map_collection(Task::orderBy('created_at','desc')->get());
    }
    public function show(ShowTask $request, Task $task) // Route Model Binding
    {
        return $task->map();
//        return Task::findOrFail($request->task);
    }
    public function destroy(DestroyTask $request, Task $task)
    {
        $task->delete();
        event(new TaskDelete($task, Auth::user()));

    }
    public function store(StoreTask $request)
    {
        $task = new Task();
        $task->name = $request->name;
        $task->completed = $request->completed ? true : false ;
        $task->user_id = $request->user_id;
        $task->description = $request->description;
        $task->save();
        event(new TaskStored($task, Auth::user()));
        return $task->map();
    }
    public function update(UpdateTask $request, Task $task)
    {
        $task_old = $task;
        $task->name = $request->name;
        $task->completed = $request->completed;
        $task->user_id = $request->user_id;
        $task->description = $request->description;
        $task->save();
        event(new TaskUpdate($task_old, $task, Auth::user()));
        return $task->map();
    }
}
