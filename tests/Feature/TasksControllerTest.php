<?php
// PSR-4
namespace Tests\Feature;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class TasksTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_show_tasks()
    {
//        $this->withoutExceptionHandling();
        //1 Prepare
        create_example_tasks();
//        dd(Task::find(1));
        // 2 execute
        $response = $this->get('/tasks');
//        dd($response->getContent());
        //3 Comprovar
        $response->assertSuccessful();
        $response->assertSee('Tasques');
        $response->assertSee('comprar pa');
        $response->assertSee('comprar llet');
        $response->assertSee('Estudiar PHP');
        // Comprovar que es veuen les tasques que hi ha a la
        // base dades
    }

    /**
     * @test
     */
    public function can_store_task()
    {
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
//    public function user_without_permissions_cannnot_delete_tasks()
//    {
//        $response = $this->delete('/tasks/1');
//        $response->assertStatus(403);
//    }
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
    /**
     * @test
     */
    public function can_edit_task()
    {
        // 1
        $oldTask = factory(Task::class)->create([
            'name' => 'Comprar llet'
        ]);

        // 2
        $response = $this->json('PUT','/api/v1/tasks/' . $oldTask->id, [
            'name' => 'Comprar pa'
        ]);

        // 3
        $result = json_decode($response->getContent());
        $response->assertSuccessful();

//        $this->assertDatabaseMissing('tasks', $oldTask);
//        $this->assertDatabaseHas('tasks', $newtask);

        $newTask = $oldTask->refresh();
        $this->assertNotNull($newTask);
        $this->assertEquals('Comprar pa',$result->name);
        $this->assertFalse((boolean) $newTask->completed);
    }
    /**
     * @test
     */
    public function can_edit_a_task_todo_validation()
    {
        $this->withoutExceptionHandling();
        // 1
        $task = Task::create([
            'name' => 'asdasdasd',
            'completed' => false
        ]);
        //2
        $response = $this->put('/tasks/' . $task->id,$newTask = [
            'completed' => true
        ]);
        $response->assertSuccessful();

        $task = $task->fresh();
        $this->assertEquals($task->name,'Comprar pa');
        $this->assertEquals($task->completed,true);
    }
    /**
     * @test
     */
    public function cannot_edit_an_unexisting_task()
    {
//        $this->withoutExceptionHandling();
        // TDD CompletedTaskControllerTest Driven Development ->
        // 2 execute HTTP REQUEST -> HTTP RESPONSE (resposta)
        $response = $this->put('/tasks/1',[]);
//        dd($response->getContent());
        // 3 assert
        $response->assertStatus(404);
    }
    /**
     * @test
     */
    public function can_show_edit_form()
    {
        // 1
        $task = Task::create([
            'name' => 'Comprar pa',
            'completed' => false
        ]);
        $response = $this->get('/task_edit/' . $task->id);
        $response->assertSuccessful();
        $response->assertSee('Comprar pa');
    }
    /**
     * @test
     */
    public function cannot_show_edit_form_unexisting_task()
    {
//        $this->withoutExceptionHandling();
        $response = $this->get('/task_edit/1');
        $response->assertStatus(404);
    }

}
Class CompletedTaskController{
    public function store()
    {

    }

    public function delete()
    {

    }

}
