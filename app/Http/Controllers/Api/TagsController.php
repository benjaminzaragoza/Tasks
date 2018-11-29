<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyTag;
use App\Http\Requests\IndexTag;
use App\Http\Requests\ShowTag;
use App\Http\Requests\StoreTag;
use App\Http\Requests\UpdateTag;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{

    public function index(IndexTag $request)
    {
        $tags = map_collection(Tag::orderBy('created_at','desc')->get());
        return $tags;
    }
    public function show(ShowTag $request, Tag $tag) // Route Model Binding
    {
       return $tag->map();
    }
    public function destroy(DestroyTag $request, Tag $tag)
    {
        $tag->delete();
    }
    public function store(StoreTag $request)
    {
        $tag = Tag::create($request->all());
        return $tag->map();
    }
    public function update(UpdateTag $request, Tag $tag)
    {
        $tag->update($request->only(['name','description','color','user_id']));
        $tag->save();
        return $tag->map();

//        $tag->update($request->all());
//        $tag->save();
//        return $tag->map();
    }
}
