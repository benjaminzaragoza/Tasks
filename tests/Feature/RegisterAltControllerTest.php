<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 31/10/18
 * Time: 16:29
 */

namespace Tests\Feature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterAltControllerTest extends TestCase
{
    use RefreshDatabase;

    //Afegir register_alt al fitxer routers/web.php
    //afeguir controller register alt controller i mode store
    //dins el store
    //objecte request per la validacio
    //user:create
    //login
    //redirect

    /**
     * @test
     */
    public function can_register_user(){

        $this->withoutExceptionHandling();
        //1 - no cal
        $this->assertNull(Auth::user());
        //2
        $response = $this->post('/register_alt',$user=[
            'name' => 'Benjamin Zaragoza',
            'email' => 'benjaminzaragoza@iesebre.com',
            'password' => 'secret11', //password per defecte factoria
            'password_confirmation'=>'secret11'
        ]);
        //3         //Mirar si sa creat ala base de dades

        $response->assertStatus(302);
        $response->assertRedirect('/home');

        $this->assertEquals($user['email'],Auth::user()->email);
        $this->assertEquals($user['name'],Auth::user()->name);

        $this->assertNotNull(Auth::user());

        $this->assertTrue(Hash::check($user['password'],Auth::user()->password));
    }
    /**
     * @test
     */
    public function can_not_user_register(){

        //1 - no cal

        //2
        $response = $this->post('/register',[
            'name' => '',
            'email' => '',
            'password' => '', //password per defecte factoria
            'password_confirmation'=>''

        ]);
        //3
        $response->assertStatus(302);
        $response->assertRedirect('/');

    }
}