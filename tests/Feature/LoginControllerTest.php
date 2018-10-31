<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 26/10/18
 * Time: 16:15
 */

namespace Tests\Feature;
use App\Task;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
    */
    public function can_login_a_user()
    {
        //1
        $user = factory(User::class)->create([
            'email'=>'benjaminzaragoza@gmail.com'
        ]);
        $this->assertNull(Auth::user());

        //2
        $response = $this->post('/login',[
            'email' => 'benjaminzaragoza@gmail.com',
            'password' => 'secret' //password per defecte factoria
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/home');

    $this->assertNotNull(Auth::user());

        //3
    }
    /**
     * @test
     */
    public function cannot_login_an_user_with_incorrect_password()
    {
        //1
        $user = factory(User::class)->create([
            'email'=>'benjaminzaragoza@gmail.com'
        ]);
        $this->assertNull(Auth::user());
        //2

        $response = $this->post('/login',[
            'email' => 'benjaminzaragoza@gmail.com',
            'password' => 'asdadadad'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertNull(Auth::user());

        //3
    }
    /**
     * @test
     */
    public function cannot_login_an_user_with_incorrect_user()
    {
        //1
        $user = factory(User::class)->create([
            'email'=>'benjaminzaragoza@gmail.com'
        ]);
        $this->assertNull(Auth::user());
        //2

        $response = $this->post('/login',[
            'email' => 'asdasdasd@gmail.com',
            'password' => 'secret'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertNull(Auth::user());

        //3
    }
}