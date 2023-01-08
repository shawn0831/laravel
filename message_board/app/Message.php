<?php

namespace App;

// use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // 批量賦值
    protected $fillable = ['username','content'];

    // 定義關聯
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function replys(){
        return $this->hasmany(Reply::class);
    }
}
