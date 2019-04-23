<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 4/04/19
 * Time: 21:12
 */

namespace App\Notifications;
use Composer\Factory;


class MobileCodesGenerator
{
    public static function generate()
    {
        $faker = Factory::create();
        return $faker->numberBetween($min = 000000, $max = 999999);
    }
}
