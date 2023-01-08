<?php
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// 認證路由
Auth::routes();
// OAuth
// Route::get('/Auth/github', 'Auth/OAuthController@redirectToProvider');
// Route::get('/Auth/github/callback', 'Auth/OAuthController@handleProviderCallback');

// 根域名
Route::get('/', 'HomeController@index')->name('home');
// home
Route::get('/home', 'HomeController@index')->name('home');

// MessageController 路由
Route::get('/message','MessageController@index');
Route::post('/message','MessageController@store');
Route::delete('/message/{message}','MessageController@destroy');

Route::get('/message/{message}','MessageController@reply_index');
Route::post('/message/{message}','MessageController@reply_store');
Route::delete('/message/{message}/{reply}','MessageController@reply_destroy');

// 路由呼叫 Artisan 指令
Route::get('/foo',function(){
    // 背景執行
    $exitCode = Artisan::call('email:send',['user'=>1,'--queue'=>'default']);
    // echo $exitCode;

    // 隊列背景執行
    Artisan::queue('email:send',['user'=>1,'--queue'=>'default']);

    // 傳遞非字串的選項值
    $exitCode = Artisan::call('migrate:refresh',['--force'=>true]);
    // echo $exitCode;

});

// stripe
// order
Route::get('/order','OrderController@getToken')->name('order.get');
Route::post('/order','OrderController@saveToken')->name('order.save');
Route::get('/direct','OrderController@direct')->middleware('subscribe')->name('order.direct');

// invoice
Route::get('/order/invoice/{invoice}',function(Request $request, $invoiceId){
    return $request->user()->downloadInvoice($invoiceId,[
        'vendor'=>'Your Company',
        'product'=>'Your Product',
    ]);
})->name('order.invoice.download');

// plan
Route::get('/plan','PlanController@index')->name('plan.index');
Route::get('/plan/{plan}','PlanController@show')->name('plan.show');
Route::post('/subscription','SubscriptionController@create')->name('subscription.create');

// webhook
Route::post('/webhook','webhookController@handleInvoicePaymentSucceed')->name('webhook.InvoicePaymentSucceed');

// mailable
// Previewing Mailables In The Browser
Route::get('mailable',function(Request $request){
    $user = $request->user(); 
    return new App\mail\OrderShipped_test($user);
});

// Session
Route::get('/order/{id}','OrderController@show')->name('order.show');
// Route::get('/order/{id}',function(Request $request){
//     // Retrieving Data
//     $value = $request->session()->get('key');
//     echo $value;
//     echo "<br>";

//     $value = $request->session()->get('key','default1');
//     echo $value;
//     echo "<br>";

//     $value = $request->session()->get('key',function(){
//         return 'default2';
//     });
//     echo $value;
//     echo "<br>";

//     // The Global Session Helper
//     $value = session('key');
//     echo $value;
//     echo "<br>";

//     $value = session('key','default');
//     echo $value;
//     echo "<br>";

//     $value = session(['key'=>'value']);
//     echo $value;
//     echo "<br>";
// });

