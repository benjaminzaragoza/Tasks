<?php

namespace App\Listeners;

use App\Log;
use App\Task;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTaskCompleted implements ShouldQueue
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
        return Log::create([
            'text' => "La Tasca '".$event->task->name."' ha estat completada",
            'time' => Carbon::now(),
            'action_type' => 'completar',
            'module_type' => 'Tasques',
            'icon' => 'lock',
            'color' => 'primary',
            'user_id' => $event->user->id,
            'loggable_id' => $event->task->id,
            'loggable_type' => Task::class,
            'old_value' => !$event->task->status,
            'new_value' => $event->task->status
        ]);
    }
}
