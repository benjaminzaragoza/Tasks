<?php

namespace Tests\Unit;

use App\Events\TaskStored;
use App\Listeners\SendMailTaskStored;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendEMailTaskStoredTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function email_has_been_sent_when_task_updated()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $task = factory(Task::class)->create();
        $user->addTask($task);

        $listener = new SendMailTaskStored();
        $listener->handle(new TaskStored($task, $user));

        Mail::assertSent(\App\Mail\TaskStored::class, function($mail) use ($task, $user) {
            return  $mail->task->is($task) &&
                $mail->hasTo($user->email) &&
                $mail->hasCc(config('tasks.manager_email'));
        });
    }
}
