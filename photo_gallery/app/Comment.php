<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'photo_id', 'comment', 'creater', 'updater',
    ];

    // 關聯
    function photo(){
        return $this->belongsTo(Photo::Class);
    }
}
