<?php

namespace App\Listeners;

use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Changelog;
use Auth;

class LogTaskDelete
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $log = Log::create([
            'text' => "La Tasca '".$event->task->name."' ha estat esborrada correctament",
            'time' => Carbon::now(),
            'action_type' => 'delete',
            'module_type' => 'Tasks',
            'icon' => 'delete',
            'color' => 'red',
            'user_id' => Auth::user()->id,
            'loggable_id' => $event->task->id,
            'loggable_type' => Task::class,
            'old_value' => $event->task,
            'new_value' => null
        ]);
        event(new Changelog($log, Auth::user()->map()));
    }
}
