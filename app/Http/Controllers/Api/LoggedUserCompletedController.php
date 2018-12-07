<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 15/10/18
 * Time: 21:16
 */
namespace App\Http\Controllers;

use App\Http\Requests\DestroyUserTaskCompleted;
use App\Http\Requests\StoreUserTaskCompleted;
use App\Task;
use Illuminate\Http\Request;

class LoggedUserCompletedController
{
    public function destroy(DestroyUserTaskCompleted $request, Task $task)
    {
        $task->completed=false;
        $task->save();
        dd('destroy');
    }
    public function store(StoreUserTaskCompleted $request, Task $task)
    {
        $task->completed=true;
        $task->save();
        dd('store');

    }
}