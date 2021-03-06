<?php

namespace App\Listeners;

use App\Mail\TaskCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMailTaskCompleted implements ShouldQueue
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

        Mail::to($event->user)
            ->cc(config('tasks.manager_email'))
            ->send(new TaskCompleted($event->task));
    }
}
