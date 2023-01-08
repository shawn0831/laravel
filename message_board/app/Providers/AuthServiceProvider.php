<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

// 客製化認證守衛
use Auth;
use App\Services\Auth\JwtGuard;
// 客製化使用者提供者
use App\Extensions\RiakUserProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 定義授權邏輯
        'App\Message' => 'App\Policies\MessagePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        // // 客製化認證守衛
        // Auth::extend('jwt',function($app,$name,array $config){
        //     return new JwtGuard(Auth::createProvider($config['provider']));
        // });
        // // 客製化UserProvider
        // Auth::provider('riak',function($app,array $config){
        //     return new RiakUserProvider($app['riak.connection']);
        // });

        // // 定義認授權邏輯
        // // ========================================================
        // // 閉包
        // $gate->define('update-message',function($user,$message){
        //     return $user->id === $message->user_id;
        // });
        // // 類別方法
        // // $gate->define('update-message','class@method');

        // // 跳過授權檢查 (函式會在所有授權檢查前觸發)
        // $gate->before(function($user,$ability){
        //     // if($user->isSuperAdmin()){
        //     //     return true;
        //     // };
        // });
        // // *如果 before 的回呼回傳一個非 null 的結果，則該結果會被作為檢查的結果。

        // // 在授權檢查後執行的函式 (不應該修改授權檢查的結果)
        // $gate->after(function($user,$ability,$result,$arguments){

        // });

        // // 傳遞多個參數
        // $gate->define('update-reply',function($user,$message,$reply){
        //     if($user->id === $reply->user_id && $message->id === $reply->message_id){
        //         return true; 
        //     }
        // });

    }

    public function register(){
        // 
    }
}
