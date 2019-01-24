<?php

namespace Tests\Unit;

use App\Events\TagDelete;
use App\Events\TaskDelete;
use App\Events\TaskStored;
use App\Listeners\LogTagDelete;
use App\Listeners\LogTaskDelete;
use App\Listeners\LogTaskStored;
use App\Listeners\LogTaskUpdated;
use App\Tag;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogTagDeletedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function log_created_when_tag_deleted()
    {
        $user = factory(User::class)->create();
        $tag = factory(Tag::class)->create();

        $listener = new LogTagDelete();
        $result = $listener->handle(new TagDelete($tag, $user));

        $this->assertEquals($result->text, "El tag '$tag->name' ha estat esborrada correctament");
        $this->assertEquals($result->action_type, 'delete');
        $this->assertEquals($result->module_type, 'Tags');
        $this->assertEquals($result->icon, "delete");
        $this->assertEquals($result->loggable_type, Tag::class);
        $this->assertEquals($result->user_id, $user->id);
        $this->assertEquals($result->loggable_id, $tag->id);
        $this->assertEquals($result->old_value, $tag);
        $this->assertEquals($result->new_value, null);
    }
}
