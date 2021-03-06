<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 31/10/18
 * Time: 16:29
 */

namespace Tests\Feature;
use App\Mail\TestWelcomeEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_register_user(){

        //1 - no cal
        initialize_roles();
        $this->assertNull(Auth::user());
        //2
        Mail::fake();
        $response = $this->post('/register',$user=[
            'name' => 'Benjamin Zaragoza',
            'email' => 'benjaminzaragoza@iesebre.com',
            'password' => 'secret11', //password per defecte factoria
            'password_confirmation'=>'secret11'
        ]);
        Mail::assertSent(TestWelcomeEmail::class,function($mail){
            return $mail->user->name=='Benjamin Zaragoza';
        });
        //3
        //Mirar si sa creat ala base de dades
        $this->assertDatabaseHas('users',['email' => 'benjaminzaragoza@iesebre.com']);

        $response->assertStatus(302);
        $response->assertRedirect('/home');

        $this->assertNotNull(Auth::user());
        $this->assertEquals($user['email'],Auth::user()->email);
        $this->assertEquals($user['name'],Auth::user()->name);
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