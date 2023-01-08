<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'photo_name', 'file_name', 'introduction', 'creater', 'updater',
    ];

    // 關聯
    function user(){
        return $this->belongsTo(User::Class);
    }
    function comments(){
        return $this->hasMany(Comment::Class);
    }
}
