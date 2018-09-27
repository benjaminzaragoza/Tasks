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
    public function todo()
    {
        $this->withoutExceptionHandling();

        Task::create([
            'name'=> 'comprar pa',
            'completed' => false
        ]);

        dd(Task::find(1));

        $response = $this->get('/tasks');

//        dd($response->getContent());

        $response->assertSuccessful();

        $response->assertSee('Tasques');

    }
}
