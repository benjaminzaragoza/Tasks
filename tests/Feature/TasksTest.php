<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
//    use RefreshDatabase;
    public function can_show_task()
    {
        // executar /tasks
        $this->withExceptionHandling();
        //1 prepare
        Task::create([
            'name' => 'comprar pa',
            'completed' => 'false'
        ]);
        Task::create([
            'name' => 'comprar llet',
            'completed' => 'false'
        ]);
        Task::create([
            'name' => 'estudiar php',
            'completed' => 'false'
        ]);
//        dd(Task::find(1));
        // 2 execute
        $response = $this->get('/tasks');
        //3 comprovar
        $response->assertSuccessful();
        $response->assertSee('Tasques');

        $response->assertSee('comprar pa');
        $response->assertSee('comprar llet');
        $response->assertSee('estudiar php');


        //comprovar que es veuen les tasques que hi ha a la base de dades
    }

    /**
     * @test
     */
    public function can_store_task()
    {
//        $this->withoutExceptionHandling();
        $response = $this->post('/tasks',[
            'name' => 'Comprar llet'
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks',['name' => 'Comprar llet']);
    }
    /**
     * @test
     */
    public function cannnot_delete_an_unexisting_task()
    {
        $response = $this->delete('/tasks/1');
        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function can_delete_task()
    {
        $this->withoutExceptionHandling();
        // 1
        $task = Task::create([
            'name' => 'Comprar llet'
        ]);
        // 2
        $response = $this->delete('/tasks/' . $task->id);
        // 3
        $response->assertStatus(302);
        $this->assertDatabaseMissing('tasks',['name' => 'Comprar llet']);
    }
//    /**
//     * @test
//     */
//    public function cannot_delete_task_an_unexisting()
//    {
//        $response = $this->delete('/task/1');
//        $response->assertStatus(404);
//    }
}
