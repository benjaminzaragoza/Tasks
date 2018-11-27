<?php
namespace App\Http\Controllers;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(TagsIndex $request){
//        return view('tasks_vue');
        $tags = Tag::orderBy('created_at','desc')->get();
        return view('/tags/index', compact('tags'));

    }
}