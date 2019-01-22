<?php

namespace App\Listeners;

use App\Log;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogTagUpdated
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
            'text' => "El Tag '".$event->tag->name."' ha estat actualitzat correctament",
            'time' => Carbon::now(),
            'action_type' => 'store',
            'module_type' => 'Tags',
            'icon' => 'edit',
            'color' => 'yellow',
            'user_id' => $event->user->id,
            'loggable_id' => $event->tag->id,
            'loggable_type' => Tag::class,
            'old_value' => $event->old_tag,
            'new_value' => $event->tag
        ]);
    }
}
