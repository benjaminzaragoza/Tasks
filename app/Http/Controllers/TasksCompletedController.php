<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 15/10/18
 * Time: 21:16
 */
namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TasksCompletedController
{
    public function store(Request $request)
    {
        $task = Task::findOrFail($request->task);
        if (!$task->completed = true) $task->completed = true; $task->save();
//        if (!$task->completed = false) $task->completed = false; $task->save();
        return redirect ('/tasks');
    }
    public function destroy(Request $request)
    {
        $task = Task::findOrFail($request->task);
        if (!$task->completed = false) $task->completed = false; $task->save();
        return redirect ('/tasks');
    }
}