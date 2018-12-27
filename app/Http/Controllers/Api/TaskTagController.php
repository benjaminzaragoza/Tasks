<?php
namespace App\Http\Controllers\Api;
use App\Tag;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class TaskTagController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $tag = Tag::findOrFail($request->tag['id']);
        $task->addTag($tag);
        return $tag->map();
    }
    public function destroy(Request $request, Task $task)
    {
        $tag = Tag::findOrFail($request->tag['id']);
        $task->destroyTag($tag);
        return $tag->map();
    }
}