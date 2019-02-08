<?php

namespace Tests\Unit;

use App\Events\TagDelete;
use App\Events\TaskDelete;
use App\Events\TaskStored;
use App\Listeners\ForgetTaskCache;
use App\Listeners\LogTagDelete;
use App\Listeners\LogTaskDelete;
use App\Listeners\LogTaskStored;
use Illuminate\Support\Facades\Cache;
use App\Tag;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForgetTaskCacheTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_forget_tasks_cache()
    {
     $listener=new ForgetTaskCache();

        $task=Task::create([
           'name'=>'prova'
        ]);
        $user=User::create([
            'name'=>'paco',
            'email'=>'paco@gmail.com',
            'password'=>'123456'
        ]);
        Cache::shouldReceive('forget')
            ->once()
            ->with(Task::TASKS_CACHE_KEY);

     $listener->handle(new TaskStored($task,$user) );
    }
}
