<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 3/12/18
 * Time: 19:54
 */

namespace Tests\Unit;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function send_email()
    {
        //1
        $user = factory(User::class)->create();
        //2
        Mail::to($user)->send(new TestEmail());
    }
}