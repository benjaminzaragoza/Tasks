<?php

namespace App\Http\Middleware;
use Illuminate\Support\Str;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    const INVALID_PATHS = [
        'impersonate',
        'login'
    ];

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
//        return route('login');
        $loginUrl = $this->validBackPath($request->path()) ? route('login') . '?back=' . $request->path() : route('login');
        return $loginUrl;
    }
    private function validBackPath($path) {
        if ($path) {
            if (collect(self::INVALID_PATHS)->first(function ($value) use ($path) {
                return Str::startsWith($path,$value) || Str::startsWith($path,'/'. $value);
            })) return false;
        }
        return true;
    }
}
