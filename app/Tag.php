<?php

namespace App;

use App\Traits\FormattedDates;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use FormattedDates;
    protected $fillable = ['name','description','color','user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignUser(User $user)
    {
        $this->user()->associate($user);
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
            'updated_at_timestamp' => $this->updated_at_timestamp,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->name,
            'user_email' => optional($this->user)->email,
            'user_gravatar' => optional($this->user)->gravatar,
            'user' => $this->user
        ];
    }

}
