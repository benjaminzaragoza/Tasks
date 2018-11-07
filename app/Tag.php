<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];
    protected $hidden = [
        'created_at'
    ];
    public function file()
    {
        return $this->hasOne(File::class);
    }
    public function assignFile(File $file)
    {
        $file->task_id = $this->id;
        $file->save();
    }
    public function addTags($tags)
    {
        $this->tags()->saveMany($tags);
    }
    public function addTag($tag)
    {
        $this->tags()->save($tag);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function map()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
//            'tags' => $this->tags
//            'file' => $this->file
        ];
    }

}
