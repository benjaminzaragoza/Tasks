<?php

namespace Tests\Unit;
use App\File;
use App\Tag;
use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_assign_user_to_task()
    {
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);

        $userOriginal=factory(User::class)->create();

        $task->assignUser($userOriginal);

        $user=$task->user;
        $this->assertTrue($user->is($userOriginal));
    }
    /**
     * @test
     */
    public function can_assign_tag_to_task() {
        // 1 Prepare 1-1
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);
        $tag = Tag::create([
            'name' => 'home',
            'description' => 'hola2',
            'color' => 'blau'
        ]);
        // execució
        $task->addTag($tag);
        // Assertion

        $tags = $task->tags;
        $this->assertTrue($tags[0]->is($tag));

    }
    /**
     * @test
     */
    public function a_task_can_have_tags() {
        // 1 Prepare n-n
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);
        $tag1 = Tag::create([
            'name' => 'home',
            'description' => 'hola2',
            'color' => 'blau'
        ]);
        $tag2 = Tag::create([
            'name' => 'work',
            'description' => 'work2',
            'color' => 'blau'
        ]);
        $tag3 = Tag::create([
            'name' => 'studies',
            'description' => 'w2',
            'color' => 'blau'
        ]);
        $tags = [$tag1, $tag2, $tag3];
        // execució
        $task->addTags($tags);
        // Assertion

        $tags = $task->tags;
        $this->assertTrue($tags[0]->is($tag1));
        $this->assertTrue($tags[1]->is($tag2));
        $this->assertTrue($tags[2]->is($tag3));
    }
    /**
     * @test
     */
    public function a_task_can_have_one_file()
    {
        // 1 Prepare
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);
        $fileOriginal = File::create([
            'path' => 'fitxer1.pdf'
        ]);
//        add_file_to_task($file, $task);
        $task->assignFile($fileOriginal);
        // 2 Executo -> Wishful programming
        // 1 Aixó torna tota la relació, treball extra
        // 2 Això retorna el object:
        $file = $task->file;
        // 3 Comprovo
        // $file
        $this->assertTrue($file->is($fileOriginal));
    }
    /**
     * @test
     */
    public function a_task_file_returns_null_when_no_file_is_assigned()
    {
        // 1 Prepare
        $task = Task::create([
            'name' => 'Comprar pa'
        ]);
        // 2 Executo -> Wishful programming
        $file = $task->file;
        // 3 Comprovo
        // $file
        $this->assertNull($file);
    }
    /**
     * @test
     */
    public function can_toogle_completed()
    {
        $task = factory(Task::class)->create([
            'completed'=>false
        ]);
        $task->toggleCompleted();
        $this->assertTrue($task->completed);

        $task = factory(Task::class)->create([
            'completed'=>true
        ]);
        $task->toggleCompleted();
        $this->assertFalse($task->completed);
    }
    /**
     * @test
     */
    public function map()
    {
        //preparar
        $user = factory(User::class)->create([
            'name' => 'Pepe Pardo Jeans',
            'email' => 'pepepardo@jeans.com'
        ]);        $task=Task::create([
            'name'=>'Comprar pa',
            'completed'=>false,
            'user_id'=>$user->id
        ]);
        //executar
        $task->assignUser($user);

        $mappedTask = $task->map();
        $this->assertEquals($mappedTask['id'],1);
        $this->assertEquals($mappedTask['name'],'Comprar pa');
        $this->assertEquals($mappedTask['completed'],false);
        $this->assertEquals($mappedTask['user_id'],$user->id);
        $this->assertEquals($mappedTask['user_name'],$user->name);
        $this->assertEquals($mappedTask['user_email'],$user->email);
        $this->assertNotNull($mappedTask['created_at']);
        $this->assertNotNull($mappedTask['created_at_formatted']);
        $this->assertNotNull($mappedTask['created_at_human']);
        $this->assertNotNull($mappedTask['created_at_timestamp']);
        $this->assertNotNull($mappedTask['updated_at']);
        $this->assertNotNull($mappedTask['updated_at_human']);
        $this->assertNotNull($mappedTask['updated_at_formatted']);
        $this->assertNotNull($mappedTask['updated_at_timestamp']);
        $this->assertEquals($mappedTask['user_gravatar'],'https://www.gravatar.com/avatar/6849ef9c40c2540dc23ad9699a79a2f8');
        $this->assertEquals($mappedTask['full_search'],'1 Comprar pa Bla bla bla Pendent Pepe Pardo Jeans pepepardo@jeans.com');

        $this->assertTrue($user->is($mappedTask['user']));
    }
}
