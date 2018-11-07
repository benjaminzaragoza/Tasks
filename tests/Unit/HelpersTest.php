<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 25/10/18
 * Time: 20:18
 */

namespace Tests\Unit;


use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelpersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_primary_user()
    {
        create_primary_user();
        $user = User::where('email','benjaminzaragoza@iesebre.com')->first();
        $this->assertEquals($user->name, 'Benjamin Zaragoza Pla');
        $this->assertEquals($user->email, 'benjaminzaragoza@iesebre.com');
        $this->assertTrue(Hash::check(env('PRIMARY_USER_PASSWORD','123456'), $user->password));
    }

}