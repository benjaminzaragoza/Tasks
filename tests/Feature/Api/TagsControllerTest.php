<?php

namespace Tests\Feature\Api;
use App\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Traits\CanLogin;
use Tests\TestCase;
class TagsControllerTest extends TestCase
{
    use RefreshDatabase,CanLogin;
    // CRUD -> CRU -> CREATE RETRIEVE UPDATE DELETE
    // BREAD -> PA -> BROWSE READ EDIT ADD DELETE
    /**
     * @test
     */
    public function can_show_a_tag()
    {
//        $this->withoutExceptionHandling();
        $this->loginAsTagsManager('api');
        $tag = factory(Tag::class)->create();
        $response = $this->json('GET','/api/v1/tags/' . $tag->id);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($tag->name, $result->name);
        $this->assertEquals($tag->description, $result->description);
        $this->assertEquals($tag->color, $result->color);
    }
    /**
     * @test
     */
    public function can_delete_tag()
    {
        $this->withoutExceptionHandling();

        $this->loginAsTagsManager('api');
        // 1
        $tag = factory(Tag::class)->create();
        // 2
        $response = $this->json('DELETE','/api/v1/tags/' . $tag->id);
        // 3
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals('', $result);
//        $this->assertDatabaseMissing('tags', $tag);
        $this->assertNull(Tag::find($tag->id));
    }
    /**
     * @test
     */
    public function can_create_tag()
    {
        $this->withoutExceptionHandling();

        $this->loginAsTagsManager('api');

        $response = $this->json('POST','/api/v1/tags/',[
            'name' => 'Comprar pa',
            'description'=>'hola que tal',
            'color'=>'blau'
        ]);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertNotNull($tag = Tag::find($result->id));
        $this->assertEquals('Comprar pa',$result->name);
        $this->assertEquals('hola que tal',$result->description);
        $this->assertEquals('blau',$result->color);

    }
    /**
     * @test
     */
    public function can_list_tags()
    {
        $this->loginAsTagsManager('api');

        //1
        create_example_tags();
        $response = $this->json('GET','/api/v1/tags');
        $response->assertSuccessful();
        $result = json_decode($response->getContent());
        $this->assertCount(3,$result);
        $this->assertEquals('comprar pa', $result[0]->name);
        $this->assertEquals('hola que tal', $result[0]->description);
        $this->assertEquals('#17afe4', $result[0]->color);
        $this->assertEquals('comprar llet', $result[1]->name);
        $this->assertEquals('hola que mal', $result[1]->description);
        $this->assertEquals('#e41717', $result[1]->color);
        $this->assertEquals('Estudiar PHP', $result[2]->name);
        $this->assertEquals('hola que fatal', $result[2]->description);
        $this->assertEquals('#17e421', $result[2]->color);
    }
    /**
     * @test
     */
    public function can_edit_tag()
    {
        $this->withoutExceptionHandling();

        $this->loginAsTagsManager('api');

        $oldTag = factory(Tag::class)->create([
            'name' => 'feina',
            'description' => "blablab",
            'color' => 'red'
        ]);
        // 2
        $response = $this->json('PUT','/api/v1/tags/'.$oldTag->id, [
            'name' => 'classe',
            'description' => 'classethings',
            'color' => 'red'
        ]);
        // 3
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $newTag = $oldTag->refresh();
        $this->assertNotNull($newTag);
        $this->assertEquals('classe',$result->name);
        $this->assertEquals('classethings',$result->description);
        $this->assertEquals('red',$result->color);
    }
    /**
     * @test
     */
    public function cannot_edit_tag_without_name()
    {
        $this->loginAsTagsManager('api');
        // 1
        $oldTag = factory(Tag::class)->create();
        // 2
        $response = $this->json('PUT', '/api/v1/tags/' . $oldTag->id, [
            'name' => ''
        ]);
        // 3
        $response->assertStatus(422);
    }

}
