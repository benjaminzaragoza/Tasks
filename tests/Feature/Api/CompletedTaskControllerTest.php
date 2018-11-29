<?php
namespace Tests\Feature\Api;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
class CompletedTaskControllerTest extends TestCase {
    use RefreshDatabase,CanLogin;
    /**
     * @test
     */
    public function can_complete_a_task()
    {
        $this->loginAsTaskManager('api');
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => false
        ]);
        $response = $this->json('POST','/api/v1/completed_task/' . $task->id);
        $response->assertSuccessful();
        $task = $task->fresh();
        $this->assertEquals($task->completed, true);
    }
    /**
     * @test
     */
    public function cannot_complete_a_unexisting_task()
    {
        $this->loginAsTaskManager('api');
        $response = $this->json('POST','/api/v1/completed_task/1');
        //3 Assert
        $response->assertStatus(404);
    }
    /**
     * @test
     */
    public function can_uncomplete_a_task()
    {
        $this->login();
        //1
        $task = Task::create([
            'name' => 'comprar pa',
            'completed' => true,
            'description' => 'ba bla bla'
        ]);
        //2
        $response = $this->delete('/completed_task/' . $task->id);
        //3 Dos opcions: 1) Comprovar base de dades directament
        // 2) comprovar canvis al objecte $task
        $task = $task->fresh();
        $response->assertRedirect('/tasks');
        $this->assertEquals((boolean)$task->completed, false);
    }

    /**
     * @test
     */
    public function cannot_uncomplete_a_unexisting_task()
    {
        $this->login('api');

        $response= $this->delete('/api/v1/completed_task/1');
        //3 Assert
        $response->assertStatus(404);
    }
}