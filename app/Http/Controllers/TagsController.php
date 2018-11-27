<?php
namespace App\Http\Controllers;
use App\Http\Requests\IndexTag;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(IndexTag $request){
//        return view('tasks_vue');

        $tags=map_collection(Tag::all());
//        return view()
//        $tags = Tag::orderBy('created_at','desc')->get();
        return view('/tags/index', compact('tags'));

    }
}