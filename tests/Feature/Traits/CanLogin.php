<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 5/11/18
 * Time: 20:59
 */

namespace Tests\Feature\Traits;
use  App\User;

trait CanLogin
{
    /**
     * @param null $guard
     * @return mixed
     */
    protected function login($guard=null)
    {
        $user = factory(User::class)->create();
        $this->actingAs($user,$guard);
        return $user;
    }
}