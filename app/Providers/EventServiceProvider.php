<?php

namespace App\Providers;

use App\Events\TagDelete;
use App\Events\TagStored;
use App\Events\TagUpdate;
use App\Events\TaskCompleted;
use App\Events\TaskDelete;
use App\Events\TaskStored;
use App\Events\TaskUncompleted;
use App\Events\TaskUpdate;
use App\Listeners\AddRolesToRegisterUser;
use App\Listeners\LogTagDelete;
use App\Listeners\LogTagStored;
use App\Listeners\LogTagUpdated;
use App\Listeners\LogTaskDelete;
use App\Listeners\LogTaskStored;
use App\Listeners\LogTaskUncompleted;
use App\Listeners\LogTaskUpdated;
use App\Listeners\SendMailTaskDelete;
use App\Listeners\SendMailTaskStored;
use App\Listeners\SendMailTaskUncompleted;
use App\Listeners\LogTaskCompleted;
use App\Listeners\SendMailTaskCompleted;
use App\Listeners\SendMailTaskUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            AddRolesToRegisterUser::class
        ],
        TaskUncompleted::class => [
            LogTaskUncompleted::class,
            SendMailTaskUncompleted::class
        ],
         TaskCompleted::class => [
            LogTaskCompleted::class,
            SendMailTaskCompleted::class
        ],
        TaskDelete::class => [
            LogTaskDelete::class,
            SendMailTaskDelete::class
        ],
        TaskStored::class => [
            LogTaskStored::class,
            SendMailTaskStored::class
        ],
        TaskUpdate::class => [
            LogTaskUpdated::class,
            SendMailTaskUpdated::class
        ],
        TagDelete::class => [
            LogTagDelete::class,
        ],
        TagUpdate::class => [
            LogTagUpdated::class,
        ],
        TagStored::class => [
            LogTagStored::class,
        ]
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
