<?php

use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
class TasksVueControllerTest extends TestCase{
    use RefreshDatabase,CanLogin;
    /**
     * @test
     */
    public function can_show_vue_tasks()
    {

        $this->loginAsTaskManager('api');        // 2 EXECUTE
        $response = $this->get('/tasks_vue');
        // 3 ASSERT
        $response->assertSuccessful();
        $response->assertViewIs('tasks_vue');
        $response->assertViewHas('tasks',Task::all());
    }
    public function login(): void
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
    }
}
