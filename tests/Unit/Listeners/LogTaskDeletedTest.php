<?php

namespace Tests\Unit;

use App\Events\TaskDelete;
use App\Events\TaskStored;
use App\Listeners\LogTaskDelete;
use App\Listeners\LogTaskStored;
use App\Listeners\LogTaskUpdated;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogTaskDeletedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function log_created_when_task_deleted()
    {
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create();

        $listener = new LogTaskDelete();
        $result = $listener->handle(new TaskDelete($task, $user));

        $this->assertEquals($result->text, "La Tasca '$task->name' ha estat esborrada correctament");
        $this->assertEquals($result->action_type, 'delete');
        $this->assertEquals($result->module_type, 'Tasks');
        $this->assertEquals($result->icon, "delete");
        $this->assertEquals($result->loggable_type, Task::class);
        $this->assertEquals($result->user_id, $user->id);
        $this->assertEquals($result->loggable_id, $task->id);
        $this->assertEquals($result->old_value, $task);
        $this->assertEquals($result->new_value, null);
    }
}
