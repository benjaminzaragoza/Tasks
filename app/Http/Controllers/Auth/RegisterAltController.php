<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\StoreUser;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterAltController extends Controller
{
    function register(StoreUser $request){
        //TODO -> VALIDATE
        //buscar el usuari a la base de dades i comprovar password ok
        $user = User::where('email', $request->email)->first();
        if (!$user){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            Auth::login($user);
            return redirect('/home');
        }
        if($user){
            return 'USUARI JA EXISTEIX';
        }
    }
}
