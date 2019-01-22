<?php

namespace App\Http\Controllers\Api;

use App\Events\TagDelete;
use App\Events\TagStored;
use App\Events\TagUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyTag;
use App\Http\Requests\IndexTag;
use App\Http\Requests\ShowTag;
use App\Http\Requests\StoreTag;
use App\Http\Requests\UpdateTag;
use App\Tag;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
//fitxer de tags correctament
    public function index(IndexTag $request)
    {
        $tags = map_collection(Tag::orderBy('created_at','desc')->get());
        return $tags;
    }
    public function show(ShowTag $request, Tag $tag) // Route Model Binding
    {
        $tag = Tag::findOrFail($tag->id);
        return $tag->map();
    }
    public function destroy(DestroyTag $request, Tag $tag)
    {
        Tag::destroy($tag->id);
        event(new TagDelete($tag, Auth::user()));
        $tag->delete();
    }
    public function store(StoreTag $request)
    {
        $tag = Tag::create($request->all());
        event(new TagStored($tag, Auth::user()));
        return $tag->map();
    }
    public function update(UpdateTag $request, Tag $tag)
    {
        $tag_old = $tag;
        $tag->update($request->only(['name','description','color']));
        $tag->save();
        event(new TagUpdate($tag_old, $tag, Auth::user()));
        return $tag->map();
    }
}
