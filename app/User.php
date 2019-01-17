<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Session;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Passport;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    const DEFAULT_PHOTO = 'default.png';
//    const PHOTOS_PATH = 'user_photos';
    const DEFAULT_PHOTO_PATH1 = 'photos/' . self::DEFAULT_PHOTO;
    const DEFAULT_PHOTO_PATH = 'app/' . self::DEFAULT_PHOTO;

    const DEFAULT_AVATAR = 'default.png';
    const DEFAULT_AVATAR_PATH1 = 'avatar/' . self::DEFAULT_AVATAR;
    const DEFAULT_AVATAR_PATH = 'app/' . self::DEFAULT_AVATAR_PATH1;

    use HasRoles,Notifiable,HasApiTokens,Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function photo()
    {
        return $this->hasOne(Photo::class);
    }
    public function assignPhoto(Photo $photo)
    {
        $photo->user_id = $this->id;
        $photo->save();
        return $this;
    }
    public function avatars()
    {
        return $this->hasMany(Avatar::class);
    }
    public function addAvatar(Avatar $avatar)
    {
        $this->avatars()->save($avatar);
        return $this;
    }

    public function assignAvatar(Avatar $avatar)
    {
        $avatar->user_id = $this->id;
        $avatar->save();
        return $this;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
//    public function addTask(Task $task)
    public function addTask($task)
    {
        $this->tasks()->save($task);
    }
    public function addTasks($tasks)
    {
        $this->tasks()->saveMany($tasks);
    }

    public function haveTask(Task $task)
    {
        return $this->tasks()->where('id',$task->id)->first();
    }
    public function removeTask()
    {
        $this->tasks()->delete();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag){
        $this->tags()->save($tag);
    }
    /**
     * @param $tags
     */
    public function addTags($tags){
        $this->tags()->saveMany($tags);
    }
    /**
     * @param Tag $tag
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|null|object
     */
    public function haveTag(Tag $tag)
    {
        return $this->tags()->where('id',$tag->id)->first();
    }
    /**
     * @param Tag $tag
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function removeTag()
    {
        $this->tags()->delete();
    }
    /**
     * @return mixed
     */
    public function isSuperAdmin()
    {
        return $this->admin;
    }

    public function map()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gravatar' => $this->gravatar,
            'admin' => (boolean) $this->admin,
            'roles' => $this->roles()->pluck('name')->unique()->toArray(),
            'permissions' => $this->getAllPermissions()->pluck('name')->unique()->toArray()
        ];
    }
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5($this->email);
    }

    public function scopeRegular($query)
    {
        return $query->where('admin',false);
    }
    public function scopeAdmin($query)
    {
        return $query->where('admin',true);
    }
    public function canImpersonate()
    {
        return $this->isSuperAdmin();
    }
    /**
     * @return bool
     */
    public function canBeImpersonated()
    {
        return !$this->isSuperAdmin();
    }
    public function impersonatedBy()
    {
        if ($this->isImpersonated()) return User::findOrFail(Session::get('impersonated_by'));
        return null;
    }
}
