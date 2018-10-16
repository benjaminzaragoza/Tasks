<?php
namespace Tests\Feature;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompletedTaskControllerTest extends TestCase {
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_complete_a_task()
    {
        $this->withoutExceptionHandling();

        //1
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => false
        ]);
        //2
        $response = $this->post('/completed_task/' . $task->id);

        $task = $task->fresh();
        $response->assertRedirect('/tasks');
        $response->assertStatus('302');
        $this->assertEquals($task->completed, true);
    }
    /**
     * @test
     */
    public function cannot_complete_a_unexisting_task()
    {
        $response = $this->post('/completed_task/1');
        //3 Assert
        $response->assertStatus(404);
    }
    /**
     * @test
     */
    public function can_uncomplete_a_task()
    {
        //1
        $task= Task::create([
            'name' => 'comprar pa',
            'completed' => true
        ]);
        //2
        $response = $this->delete('/completed_task/' . $task->id);


        $task = $task->fresh();
        $this->assertEquals($task->completed, false);
        $response->assertRedirect('/tasks');
        $response->assertStatus('302');
    }
    /**
     * @test
     */
    public function cannot_uncomplete_a_unexisting_task()
    {

        $response= $this->delete('/completed_task/1');
        $response->assertStatus(404);
    }
}