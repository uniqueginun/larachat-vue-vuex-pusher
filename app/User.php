<?php

namespace App;

use App\Message;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile'
    ];

    protected $appends = ['unread_count'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUnreadCountAttribute() {
        return Message::where('to', auth()->id())->where('from', $this->id)->where('read', false)->count();;
    }


    public function getProfileAttribute()
    {
        return "/images/{$this->attributes['profile']}";
    }
}
