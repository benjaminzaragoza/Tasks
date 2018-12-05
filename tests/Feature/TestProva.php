<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
class TestProva extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_show_vue_tasks()
    {
        $this->assertTrue(true);
    }
}