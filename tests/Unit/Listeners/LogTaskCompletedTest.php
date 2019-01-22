<?php

use App\Log;
use App\Mail\TaskUncompleted;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogTaskCompletedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_task_Completed_log_has_been_created()
    {
        // 1 Preparar
        $user = factory(User::class)->create();
        $task = Task::create([
            'name' => 'Comprar pa',
            'user_id' => $user->id
        ]);
        Event::fake();

        // Executar
//        event(new TaskUncompleted($task));

        $listener = new \App\Listeners\LogTaskCompleted();
        $listener->handle(new \App\Events\TaskCompleted($task,$user));
        // 3 ASSERT
        // Test log is inserted
        $log  = Log::find(1);
        $this->assertEquals($log->text,"La Tasca 'Comprar pa' ha estat completada");
        $this->assertEquals($log->action_type,'completar');
        $this->assertEquals($log->module_type,'Tasques');
        $this->assertEquals($log->user_id,$user->id);
        $this->assertEquals($log->old_value,true);
        $this->assertEquals($log->new_value,0);
        $this->assertEquals($log->loggable_id,$task->id);
        $this->assertEquals($log->loggable_type,Task::class);
        $this->assertEquals($log->icon,'lock');
        $this->assertEquals($log->color,'primary');
    }
//    public function a_task_completed_log_has_been_created()
//    {
//        Event::fake();
//        $user = factory(User::class)->create();
//        $task = factory(Task::class)->create(['status' => true]);
//        $this->assertEquals($task->status, true);
//        $user->addTask($task);
//        $listener = new LogTaskCompleted();
//        $result = $listener->handle(new TaskCompleted($task, $user));
//
//        $this->assertDatabaseHas('logs', [
//            'text' => "Task '$task->name' has been completed",
//            'time' => Carbon::now(),
//            'action_type' => 'complete',
//            'module_type' => 'Tasks',
//            'icon' => 'lock',
//            'color' => 'primary',
//            'user_id' => $user->id,
//            'loggable_id' => $task->id,
//            'loggable_type' => Task::class,
//            'old_value' => false,
//            'new_value' => true
//        ]);
//    }
}
