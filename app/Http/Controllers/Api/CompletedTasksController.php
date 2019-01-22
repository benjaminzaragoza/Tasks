<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 24/10/18
 * Time: 16:44
 */

namespace App\Http\Controllers\Api;

use App\Events\TaskUncompleted;
use App\Events\TaskCompleted;

use App\Http\Requests\DestroyTaskCompleted;
use App\Http\Requests\StoreTaskCompleted;
use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CompletedTasksController
{
//    public function toggleCompleted($task)
//    {
//        $task->completed= !$task->completed;
//        $task->save();
//
//    }
//DestroyTaskCompleted
    public function destroy(DestroyTaskCompleted $request, Task $task)
    {
        $task->completed=false;
        $task->save();
        // HOOK -> EVENT
        event(new TaskUncompleted($task, $request->user()));
    }

    public function store(StoreTaskCompleted $request, Task $task)
    {
        $task->completed=true;
        $task->save();
        event(new TaskCompleted($task, $request->user()));
    }
}