<?php
/**
 * Created by PhpStorm.
 * User: joan
 * Date: 21/01/19
 * Time: 21:22
 */

namespace Tests\Unit;

use App\Events\TaskDelete;
use App\Listeners\SendMailTaskDelete;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendEmailTaskDeletedTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function email_has_been_sent_when_task_deleted()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $task = factory(Task::class)->create();
        $user->addTask($task);

        $listener = new SendMailTaskDelete();
        $listener->handle(new TaskDelete($task, $user));

        Mail::assertSent(\App\Mail\TaskDeleted::class, function($mail) use ($task, $user) {
            return  $mail->task->is($task) &&
                $mail->hasTo($user->email) &&
                $mail->hasCc(config('tasks.manager_email'));
        });
    }
}
