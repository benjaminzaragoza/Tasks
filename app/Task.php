<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
//    protected $fillable = ['name','completed'];
    protected $guarded = [];

    protected $hidden =[
        'created_at'
    ];
    public function file()
    {
        return $this->hasOne(File::class);
    }

     public function assignFile(File $file)
    {
        //relaciona el id de el fitxer i el de taskes
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
        return $this->belongsToMany(Tag::Class);

    }

    public function assignUser(User $user)
    {
        $this->user()->associate($user);
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function toggleCompleted()
    {
        $this->completed= !$this->completed;
        $this->save();

    }

    public function map()
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'completed'=>$this->completed,
            'user_id'=> $this->user_id,
            'user_name' => optional($this->user)->name,
//            'tags' => $this->tags,
//            'file' => $this->file
        ];
    }
}
