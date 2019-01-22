<?php

namespace App\Listeners;

use App\Mail\TaskDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailTaskDelete
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
            ->send(new TaskDeleted($event->task));
    }

}
