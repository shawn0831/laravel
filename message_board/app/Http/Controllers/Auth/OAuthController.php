<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Socialite;

class OAuthController extends Controller{
    // 導向github
    public function redirectToProvider(){
        return socialite::driver('github')->with(['hd'=>'example.com'])->redirect();
    }
    // 接收使用者資訊
    public function handleProviderCallback(){
        $user = socialite::driver('github')->user();

        // OAuth 2.0
        $token = $user->token;
        // OAuth 1.0
        $token = $user->token;
        $tokenSecret = $user->tokenSecret;

        // 所有OAuth提供者-提供的資訊
        $user->getId();
        $user->getNickname();
        $user->getName();
        $user->getEmail();
        $user->getAvatar();
    }
}
