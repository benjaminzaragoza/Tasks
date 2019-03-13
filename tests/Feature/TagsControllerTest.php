<?php

namespace Tests\Feature;
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
        $response->assertRedirect('login?back=tags');
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
        create_example_tags();

        $this->loginAsTagsManager();
        $this->withoutExceptionHandling();
        $response = $this->get('/tags');
        $response->assertSuccessful();
        $response->assertSee('comprar pa');

    }

}
