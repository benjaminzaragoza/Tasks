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
        $response = $this->json('put','/v1/tasks/' . $task);

        $task = $task->fresh();
//        $response->assertRedirect('/tasks');
//        $response->assertStatus('302');
        $this->assertEquals($task->completed, 1);
    }
    /**
     * @test
     */
    public function cannot_complete_a_unexisting_task()
    {
        $response = $this->json('post','/completed_task/1');
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
        $response = $this->json('delete','/tasks_uncompleted/' . $task->id);


        $task = $task->fresh();
        $this->assertEquals($task->completed, 0);
//        $response->assertRedirect('/tasks');
//        $response->assertStatus('302');
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