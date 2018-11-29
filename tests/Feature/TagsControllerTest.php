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
    public function guest_user_cannot_show_tags()
    {
        // 2 execute
        $response = $this->get('/tags');
        //3 Comprovar
        $response->assertRedirect('/login');
    }
    /**
     * @test
     */
    public function regular_user_cannot_show_tags()
    {
        $this->login();
        $response = $this->get('/tags');
        $response->assertStatus(403);
    }
    /**
     * @test
     */
    public function superadmin_can_show_tags()
    {
        $this->loginAsSuperAdmin();
        create_example_tags();
        $response = $this->get('/tags');
        $response->assertSuccessful();
//        $response->assertViewIs('tags');
        $response->assertViewHas('tags',function ($tags) {
            return count($tags) === 3 &&
                $tags[0]['name'] === 'comprar pa' &&
                $tags[1]['name'] === 'comprar llet' &&
                $tags[2]['name'] === 'Estudiar PHP';
        });
    }
    /**
     * @test
     */
    public function tags_manager_can_show_tags()
    {
        $this->withoutExceptionHandling();
        create_example_tags();
        $this->loginAsTagsManager();
        $response = $this->get('/tags');
        $response->assertSuccessful();
        $response->assertSee('tags');

    }
    /**
     * @test
     */
    public function users_with_role_tags_can_show_tags()
    {
        $this->loginAsTagsManager();
        // 2 execute
        $response = $this->get('/tags');
        //3 Comprovar
        $response->assertSuccessful();
        $response->assertSee('tags');
    }

    /**
     * @test
     */
    public function can_show_a_tag()
    {
        $this->withoutExceptionHandling();
        $this->loginAsTagsManager('api');
        $tag = factory(Tag::class)->create();
        $response = $this->json('GET','/api/v1/tags/' . $tag->id);
        $result = json_decode($response->getContent());
        $response->assertSuccessful();
        $this->assertEquals($tag->name, $result->name);
        $this->assertEquals($tag->description, $result->description);
        $this->assertEquals($tag->color, $result->color);
    }
//    /**
//     * @test
//     */
//    public function can_delete_tag()
//    {
//        $this->login('api');
//
//        // 1
//        $tag = factory(Tag::class)->create();
//        // 2
//        $response = $this->json('DELETE','/api/v1/tags/' . $tag->id);
//        // 3
//        $result = json_decode($response->getContent());
//        $response->assertSuccessful();
//        $this->assertEquals('', $result);
////        $this->assertDatabaseMissing('tags', $tag);
//        $this->assertNull(Tag::find($tag->id));
//    }
    /**
     * @test
     */
    public function cannot_create_tags_without_name()
    {
//        $this->withoutExceptionHandling();

        $this->login('api');

        $response = $this->json('POST','/api/v1/tags/',[
            'name' => ''
        ]);
        $result = json_decode($response->getContent());

        $response->assertStatus(422);
    }
    /**
     * @test
     */
    public function can_create_tag()
    {
        $this->withoutExceptionHandling();

        $this->login('api');

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
        $this->login('api');

        //1
        create_example_tags();
        $response = $this->json('GET','/api/v1/tags');
        $response->assertSuccessful();
        $result = json_decode($response->getContent());
        $this->assertCount(3,$result);
        $this->assertEquals('comprar pa', $result[0]->name);
        $this->assertEquals('hola que tal', $result[0]->description);
        $this->assertEquals('blue', $result[0]->color);
        $this->assertEquals('comprar llet', $result[1]->name);
        $this->assertEquals('hola que mal', $result[1]->description);
        $this->assertEquals('green', $result[1]->color);
        $this->assertEquals('Estudiar PHP', $result[2]->name);
        $this->assertEquals('hola que fatal', $result[2]->description);
        $this->assertEquals('red', $result[2]->color);
    }

}
