<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 24/10/18
 * Time: 16:44
 */

namespace App\Http\Controllers\Api;


use App\Task;
use Illuminate\Http\Request;

class CompletedTasksController
{
    public function toggleCompleted($task)
    {
        $task->completed= !$task->completed;
        $task->save();

    }
    //controller = new Completed
    public function destroy(Request $request, Task $task)
    {
        $task->completed=false;
        $task->save();
//        Task::findOrFail();
        //dump($request->header('User-Agent'));

    }
    public function store(Request $request, Task $task)
    {
        $task->completed=true;
        $task->save();
//        Task::findOrFail();
        //dump($request->header('User-Agent'));

    }
}