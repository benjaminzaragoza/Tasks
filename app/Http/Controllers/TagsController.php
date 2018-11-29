<?php
namespace App\Http\Controllers;
use App\Http\Requests\IndexTag;
use App\Http\Requests\IndexUserTag;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    public function index(IndexUserTag $request){
//        return view('tasks_vue');

//        $tags=map_collection(Tag::all());
//        return view('/tags/index', compact('tags'));
        $tags = [];
        if(Auth::user()->isSuperAdmin() || Auth::user()->hasRole('TagsManager')) {
            $tags = map_collection(Tag::orderBy('created_at','desc')->get());
        } else {
            $tags = map_collection($request->user()->tags);
        }
        $users = User::all();
        return view('/tags/index', compact('tags','users'));
    }
}