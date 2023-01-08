<?
namespace App\Providers;

use App\Extensions\MongoSessionHandler;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider{
    public function register(){

    }
    public function boot(){
        Session::extend('mongo', function($app){
            return new MongoSessionHandler;
        });
    }
}