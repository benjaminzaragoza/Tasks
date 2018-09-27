<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTestOld extends TestCase
{
    /**
     * @test
     */
    public function todo()
    {
        $this->withExceptionHandling();

        //Executar /tasks
        $response = $this->get('/tasks');
//        dd($respose)->getContent()

        $response->assertSuccessful();
        $response->assertSee('Tasques');

    }
}
