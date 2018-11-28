<?php
// PSR-4
namespace Tests\Feature;
use App\Task;
use App\User;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class TasksTest extends TestCase
{
    use RefreshDatabase,CanLogin;
    /**
     * @test
     */
    public function TaskManager_can_index_tasks()
    {
        $this->withoutExceptionHandling();
        create_example_tasks();
        $this->loginAsTaskManager();
        $response = $this->get('/tasques');

        $response->assertSuccessful();
    }
    /**
     * @test
     */
    public function Tasks_user_can_index_tasks()
    {
        $this->withoutExceptionHandling();
        create_example_tasks();
        $user=$this->loginAsTasksUser();
        $task=Task::create([
            'name' => 'comprar pa',
            'completed' => false,
            'description'=>'hola ',
            'user_id' => $user->id
        ]);
        $response = $this->get('/tasques');
        $response->assertSuccessful();
        $response->assertViewIs('tasques');
        $response->assertViewHas('tasks',function ($tasks){
            return count($tasks)===3 &&
                $tasks[0]['name']==='comprar pa'&&
                $tasks[1]['name']==='comprar llet'&&
                $tasks[2]['name']==='Estudiar PHP';
        });
    }
    /**
     * @test
     */
    public function Regular_User_cannot_index_tasks()
    {
        $this->login();
        $response = $this->get('/tasques');
        $response->assertStatus(403);
    }
    /**
     * @test
     */
    public function SuperAdmin_can_index_tasks()
    {
        create_example_tasks();
        $this->loginAsSuperAdmin();
        $response = $this->get('/tasques');

        $response->assertSuccessful();
    }
    /**
     * @test
     */
    public function Guest_user_cannot_index_tasks()
    {
        $response = $this->get('/tasques');
        $response->assertRedirect('/login');
    }

}

