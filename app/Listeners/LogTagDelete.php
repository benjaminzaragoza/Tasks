<?php

namespace App\Listeners;

use App\Log;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTagDelete
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
            'text' => "El tag '".$event->tag->name."' ha estat esborrada correctament",
            'time' => Carbon::now(),
            'action_type' => 'delete',
            'module_type' => 'Tags',
            'icon' => 'delete',
            'color' => 'red',
            'user_id' => $event->user->id,
            'loggable_id' => $event->tag->id,
            'loggable_type' => Tag::class,
            'old_value' => $event->tag,
            'new_value' => null
        ]);
    }
}
