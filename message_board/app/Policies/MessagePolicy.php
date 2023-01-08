<?php

namespace App\Policies;

use App\User;
use App\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    // 認證使用者傳遞至路由的留言id，是否與當前使用者的id相同
    public function destroy_authorize(User $user,Message $message){
        return $user->id === $message->user_id;
    }
    public function reply_destroy_authorize(User $user,Reply $reply){
        return $user->id === $reply->user_id;
    }

    // =================================================
    // 範例
    public function update(User $user,Message $message){
        return $user->id === $message->user_id;
        // return false;
    }

    // 在所有檢查之前運行的邏輯
    public function before($user,$ability){
        // if($user->isSuperAdmin()){
        //     return true;
        // }
    }
    // *如果回傳非null的值，將會跳過所有檢查，將值當成檢查的結果
}
