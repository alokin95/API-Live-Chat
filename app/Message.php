<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $guarded = [];

    public function messageFrom()
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function messageTo()
    {
        return $this->belongsTo(User::class, 'to');
    }
}
