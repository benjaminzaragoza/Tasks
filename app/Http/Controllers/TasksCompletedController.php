<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 15/10/18
 * Time: 21:16
 */
namespace App\Http\Controllers;

use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TasksCompletedController
{
//DestroyTaskCompleted
    public function store(Request $request, Task $task)
    {
        $task->completed = true;
        $task->save();
        return redirect('/tasks');
    }
    public function destroy(Request $request, Task $task)
    {
        $task->completed = false;
        $task->save();

        return redirect('/tasks');
    }
}