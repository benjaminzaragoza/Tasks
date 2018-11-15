<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 22/10/18
 * Time: 20:53
 */

namespace Tests\Unit;
use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_have_tasks()
    {
        //1preparar
        $user=factory(User::class)->create();
        $tasks1=factory(Task::class)->create();
        $tasks2=factory(Task::class)->create();
        $tasks3=factory(Task::class)->create();

        $user->addTask($tasks1);
        $user->addTask($tasks2);
        $user->addTask($tasks3);


        //2 executar
        $tasks=$user->tasks;

        //3 comprovar

        $this->assertTrue($tasks[0]->is($tasks1));
        $this->assertTrue($tasks[1]->is($tasks2));
        $this->assertTrue($tasks[2]->is($tasks3));

    }
    /**
     * @test
     */
    public function user_tasks_returns_null_when_no_task()
    {
        //1preparar
        $user=factory(User::class)->create();

        //2 executar
        $tasks=$user->tasks;

        //3 comprovar

        $this->assertEmpty($tasks);
    }
    /**
     * @test
     */
    public function can_add_task_to_user()
    {
        $user=factory(User::class)->create();
        $task=factory(Task::class)->create();

        $user->addTask($task);


        //2 executar
        $tasks=$user->tasks;

        //3 comprovar

        $this->assertTrue($tasks[0]->is($task));
    }
    /**
     * @test
     */
    public function can_add_tasks_to_user()
    {
        // 1 Preparar
        $user = factory(User::class)->create();
        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();
        $task3 = factory(Task::class)->create();
//        $tasks = [$task1, $task2, $task3];
        $tasks = [];
        array_push($tasks, $task1);
        array_push($tasks, $task2);
        array_push($tasks, $task3);
        // 2 executar
        $user->addTasks($tasks);
        // 3 comprovar
        $tasks = $user->tasks;
        $this->assertTrue($tasks[0]->is($task1));
        $this->assertTrue($tasks[1]->is($task2));
        $this->assertTrue($tasks[2]->is($task3));
    }


    public function haveTask()
    {
        $user = factory(User::class)->create();
        $user->haveTask();
    }

    public function removeTask()
    {
        $user = factory(User::class)->create();
        $user->removeTask();
    }
}