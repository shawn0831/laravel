<?php

namespace App\Policies;

use App\User;
use App\Photo;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommonPolicy
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
    // photo
    public function photo_authorize(User $user, Photo $photo){
        return $user->id === $photo->user_id;
    }
    // comment
    public function comment_authorize(User $user, Comment $comment){
        return $user->id === $comment->user_id;
    }
}
