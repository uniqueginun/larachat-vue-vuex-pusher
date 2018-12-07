<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
   
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

}
