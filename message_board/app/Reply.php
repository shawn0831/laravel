<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    // 批量賦值
    protected $fillable = ['user_id','username','content'];

    // 定義關聯
    public function message(){
        return $this->belongsTo(message::class);
    }
}
