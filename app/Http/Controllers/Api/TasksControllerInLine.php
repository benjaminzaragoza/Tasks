<?php
namespace App\Http\Controllers\Api;
use App\Events\TaskDelete;
use App\Events\TaskStored;
use App\Events\TaskUpdate;
use App\Http\Requests\DestroyTask;
use App\Http\Requests\IndexTask;
use App\Http\Requests\ShowTask;
use App\Http\Requests\StoreTask;
use App\Http\Requests\UpdateTask;
use App\Task;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class TasksControllerInLine extends Controller
{
    public function update(UpdateTask $request, Task $task)
    {
        $task->name = $request->name;
        $task->save();
        return $task->map();
    }
}
