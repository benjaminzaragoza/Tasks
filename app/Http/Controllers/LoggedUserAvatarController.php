<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoggedUserAvatarController extends Controller
{
    public function show(Request $request)
    {
        $request->user()->lastAvatar();
        $avatar = $this->userAvatarExists($request->user()) ? $request->user()->avatars[0]->url : $this->defaultAvatar();
//        dd($avatar);
        return response()->file(Storage::disk('local')->path($avatar), [
            'Cache-Control' => 'no-cache, must-revalidate, no-store, max-age=0, private',
            'Pragma' => 'no-cache'
        ]);
    }

    protected function userAvatarExists($user)
    {
        return $user->avatars && Storage::disk('local')->exists($user->avatars[0]->url);
    }

    protected function defaultAvatar()
    {
        return User::DEFAULT_AVATAR_PATH1;
    }
}
