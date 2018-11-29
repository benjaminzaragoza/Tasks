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
            'color' => $this->color,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'created_at_formatted' => $this->created_at_formatted,
            'created_at_human' => $this->created_at_human,
            'updated_at' => $this->updated_at,
            'updated_at_formatted' => $this->updated_at_formatted,
            'updated_at_human' => $this->updated_at_human,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->name,
            'user_email' => optional($this->user)->email,
            'user_avatar' => optional($this->user)->avatar,
            'user' => $this->user
        ];
    }

}
