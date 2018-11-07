<?php

namespace Tests\Unit;
use App\File;
use App\Tag;
use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class TagTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function map()
    {
        //preparar
        $tag = factory(Tag::class)->create();
        $tag=Tag::create([
            'name'=>'Comprar pa',
            'description'=>'Comprar pa',
            'color'=>'blau'
        ]);
        //executar
        $mappedTask = $tag->map();
        $this->assertEquals($mappedTask['id'],1);
        $this->assertEquals($mappedTask['name'],'Comprar pa');
        $this->assertEquals($mappedTask['description'],'comprar pa');
        $this->assertEquals($mappedTask['color'],'blau');
    }
}
