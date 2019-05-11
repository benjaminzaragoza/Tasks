<?php
/**
 * Created by PhpStorm.
 * User: benjamin
 * Date: 4/04/19
 * Time: 21:12
 */

namespace App\CodeGenerator;

use Faker\Factory;


class MobileCodesGenerator
{
    public static function generate()
    {
        $code = random_int(100000, 999999);
        return $code;
    }
}
