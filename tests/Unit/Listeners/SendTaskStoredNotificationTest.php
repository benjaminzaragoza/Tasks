<?php

use App\Listeners\SendTaskStoredNotification;
use App\Mail\TaskUncompleted;
use App\Notifications\TaskStored;
use App\Events\TaskStored as TaskStoredEvent;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendTaskStoredNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function send_task_stored_notification()
    {
        $listener=new SendTaskStoredNotification();
        $user=factory(User::class)->create();
        $task=factory(Task::class)->create([
            'user_id'=>$user->id
        ]);
        $event= new TaskStoredEvent($task,$user);
        Notification::fake();
        $listener -> handle();
        Notification::assertSentTo(
            $user,
            TaskStored::class,
            function ($notification, $channels) use ($task) {
                return $notification->task->id === $task->id;
            }
        );
    }
}
