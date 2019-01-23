<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 23/01/19
 * Time: 17:24
 */

namespace Tests\Feature\Api;
use App\Tag;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;

class TasksTagsControllerTest extends TestCase
{
    use RefreshDatabase,CanLogin;

    /**
     * @test
     */
    public function can_add_tag_to_task()
    {
        $this->loginAsTaskManager('api');
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);
        $tag = Tag::create([
            'name' => 'home',
            'description' => 'bla bla',
            'color' => 'blue'
        ]);

        $response =$this-> json('PUT','/api/v1/tasks/'.$task->id.'/tags/'.[
            'tags'=>[$tag->id]
            ]);
        $response->assertSuccessful();

        $task = $task->fresh();

        $this->assertCount(1,$task->tags);
        $this->assertEquals('home',$task->tags[0]->name);
        $this->assertTrue($task->tags[0]->is($tag));
//        $this->assertEquals($task->tags[0]->is($tag));


    }
}