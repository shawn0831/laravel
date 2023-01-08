<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
// anchor subscription billing cycle
use Carbon\Carbon;
// Sending Mail
use Illuminate\Support\Facades\Mail;
// Testing
use App\Mail\OrderShipped_test;

class OrderController extends Controller
{
    // 綁定中介層
    public function __construct(){
        $this->middleware('auth');
    }

    public function getToken(Request $request){
        $user = $request->user();

        return view('order.index',[
            'intent'=>$user->createSetupIntent(),
        ]);
    }

    public function saveToken(Request $request){
        $holder_name = $_POST['holder-name'];
        $phone = $_POST['phone'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $token = $_POST['stripeToken'];

        // session_start();
        // $_SESSION['payment_method_token']=$token;
        // echo $_SESSION['payment_method_token'];
        // echo "<br>";

        $user = $request->user();
        $user->createAsStripeCustomer();
        
        // $user->addPaymentMethod($token);
        // $user->updateDefaultPaymentMethodFromStripe($token);

        $subscription = $user->newSubscription('Basic','plan_GCrZLyACwh7Cis')->withCoupon('xvHtj8Qa')->create($token,[
            'name'=>$holder_name,
            'phone'=>$phone,
            'address'=>[
                'country'=>$country,
                'city'=>$city,
                'line1'=>$address,
            ]
        ]);
        // echo "subscribed and return subscription instance";
        // echo "<br>";
        // print_r($subscription);
        // echo "<br>";
        // Basic id: plan_GCrZLyACwh7Cis
        // Professional id: plan_GCrbBuqxVVGLSQ

        // checking subscription status
        // ===================================
        // // 查看是否訂閱(包括試用期)
        // if ($user->subscribed('Basic')) {
        //     echo "subscribed";
        //     echo "<br>";
        // }
        // // 查看訂閱是否在試用期內
        // if ($user->subscription('Basic')->onTrial()) {
        //     echo "on trial";
        //     echo "<br>";
        // }
        // // 查看訂閱是否已過試用期
        // if ($user->subscription('Basic')->recurring()) {
        //     echo "subscribed, and not in trial period";
        //     echo "<br>";
        // }
        // // 查看訂閱是否已取消
        // if ($user->subscription('Basic')->cancelled()) {
        //     echo "has subscribed used to, but cancelled";
        //     echo "<br>";
        // }
        // // 查看使用者是否處在寬期限
        // // (假設使用者在到期日之前就取消了訂閱，那麼在取消訂閱至原定到期日之間的日子稱為寬期限，在這段日子裡subscribed()函式依然會返回true)
        // if ($user->subscription('Basic')->onGracePeriod()) {
        //     echo "on grace period";
        //     echo "<br>";
        // }
        // // 查看訂閱是否已取消，且不在寬期限內
        // if ($user->subscription('Basic')->ended()) {
        //     echo "subscription is cancelled and not in grace period";
        //     echo "<br>";
        // }

        // // 查看訂閱是否未完成
        // if ($user->subscription('Basic')->hasIncompletePayment()) {
        //     echo "subscription has secondary payment action, is not complete yet";
        //     echo "<br>";

        //     // 獲得未完成訂單
        //     $subscription = $user->subscription('Basic');
        //     echo $subscription->latestPayment()->id;
        // }
        // if ($user->hasIncompletePayment('Basic')) {
        //     echo "subscription has secondary payment action, is not complete yet";
        //     echo "<br>";

        //     // 獲得未完成訂單
        //     $subscription = $user->subscription('Basic');
        //     echo $subscription->latestPayment()->id;
        // }

        
        // // 查看plan ID與plan name是否吻合
        // if ($user->subscribedToPlan('plan_GCrZLyACwh7Cis','Basic')) {
        //     echo "plan ID and plan name matched";
        //     echo "<br>";
        // }
        // // 查看plan name是否與其中一個plan ID吻合
        // if ($user->subscribedToPlan(['plan_GCrZLyACwh7Cis','prod_GCranc0TZ98H1b'],'Basic')) {
        //     echo "plan name matched one of plan IDs";
        //     echo "<br>";
        // }

        // changing plans
        // ===================================
        // changing plans and keep trial period and quantity
        // if($user->subscription('Basic')->swap('plan_GCrbBuqxVVGLSQ')){
        //     echo "swap to Professional";
        //     echo "<br>";
        // };

        // // changing plans and skip trial
        // if($user->subscription('Basic')->skipTrial()->swap('plan_GCrbBuqxVVGLSQ')){
        //     echo "swap to Professional and skip trial";
        //     echo "<br>";
        // };

        // // changing plans and invoice immediately (don't wait to next billing cycle)
        // if($user->subscription('Basic')->swapAndInvoice('plan_GCrbBuqxVVGLSQ')){
        //     echo "swap to Professional and invoice immediately";
        //     echo "<br>";
        // }; 

        // subscription quantity
        // ===================================
        // // increment quantity
        // if($user->subscription('Basic')->incrementQuantity()){
        //     echo "Professional plan increment quantity 1";
        //     echo "<br>";
        // }; 

        // if($user->subscription('Basic')->incrementQuantity(5)){
        //     echo "Professional plan increment quantity 5";
        //     echo "<br>";
        // };

        // // decrement quantity
        // if($user->subscription('Basic')->decrementQuantity()){
        //     echo "Professional plan decrement quantity 1";
        //     echo "<br>";
        // }; 

        // if($user->subscription('Basic')->decrementQuantity(5)){
        //     echo "Professional plan decrement quantity 5";
        //     echo "<br>";
        // };

        // // update quantity
        // if($user->subscription('Basic')->updateQuantity(10)){
        //     echo "Professional plan update quantity 10";
        //     echo "<br>";
        // };

        // // update quantity and no prorate (雖數量改變了，但是下一期才改變收費，這一期照舊)
        // if($user->subscription('Basic')->noProrate()->updateQuantity(20)){
        //     echo "Professional plan update quantity 20 and no prorate";
        //     echo "<br>";
        // };

        // subscription taxes
        // ===================================
        // // 同步現有訂閱的稅率(與 billable model 的 taxPercentage method 的返回值同步)
        // if($user->subscription('Basic')->syncTaxPercentage()){
        //     echo "tax percentage synced";
        //     echo "<br>";
        // };

        // subscription anchor date
        // ===================================
        // $anchor = Carbon::parse('first day of next month');
        // if( $user->newsubscription('Basic','plan_GCrZLyACwh7Cis')->
        //     anchorBillingCycleON($anchor->startOfDay())->
        //     create($token)
        // ){
        //     echo "billing cycle day anchored";
        //     echo "<br>";
        // };

        // cancelling subscriptions
        // ===================================
        // cancel
        // if($user->subscription('Basic')->cancel()){
        //     echo "plan is canceled";
        //     echo "<br>";
        // };

        // test for cancel
        // if($user->subscribed('Basic')){
        //     echo "plan was subscribed";
        //     echo "<br>";
        // }
        // if($user->subscription('Basic')->onGracePeriod()){
        //     echo "plan is on grace period";
        //     echo "<br>";
        // }
        // if($user->subscription('Basic')->cancelled()){
        //     echo "has subscribed used to, but cancelled";
        //     echo "<br>";
        // }

        // cancel now
        // if($user->subscription('Basic')->cancelNow()){
        //     echo "plan is canceled immediately";
        //     echo "<br>";
        // };

        // test for cancel now
        // if($user->subscribed('Basic')){
        //     echo "plan was subscribed";
        //     echo "<br>";
        // }
        // if($user->subscription('Basic')->onGracePeriod()){
        //     echo "plan is on grace period";
        //     echo "<br>";
        // }
        // if($user->subscription('Basic')->cancelled()){
        //     echo "has subscribed used to, but cancelled";
        //     echo "<br>";
        // }

        // resuming subscriptions (only can resume subscriptions within grace period)
        // ===================================
        // if($user->subscription('Basic')->resume()){
        //     echo "subacription resumed";
        //     echo "<br>";
        // }

        // Subscription Trials
        // ======================================================================
        // with payment method up front (先蒐集 payment method，再開啟試用期)
        // ===================================
        // way 1
        // if( $user->newSubscription('Basic','plan_GCrZLyACwh7Cis')
        //     ->trialDays(10)
        //     ->create($token)
        // ){
        //     echo "subscription has subscribed and trial period has set ( use trialDays() )";
        //     echo "<br>";
        // }

        // way 2
        // if( $user->newSubscription('Basic','plan_GCrZLyACwh7Cis')
        //     ->trialUntil(Carbon::now()->addDays(15))
        //     ->create($token)
        // ){
        //     echo "subscription has subscribed and trial period has set ( use trialUntil() )";
        //     echo "<br>";
        // }

        // 檢查是否在試用期內
        // if($user->onTrial('Basic')){
        //     echo "within trial period";
        //     echo "<br>";
        // }
        // if($user->subscription('Basic')->onTrial('Basic')){
        //     echo "within trial period";
        //     echo "<br>";
        // }

        // without payment method up front (不先蒐集 payment method，直接開啟試用期) (generic trial)
        // ===================================
        // subscriptions generic trial
        // if( $user->update(['trial_ends_at' => now()->addDays(10),]) ){
        //     echo "table 'user','trial_ends_at' column updated";
        //     echo "<br>";
        // }

        // if($user->onTrial()){
        //     echo "within trial period";
        //     echo "<br>"; 
        // }
        
        // if($user->onGenericTrial()){
        //     echo "within generic trial period";
        //     echo "<br>"; 
        // }
        
        // if( $user->newSubscription('Basic','plan_GCrZLyACwh7Cis')->create($token) ){
        //     echo "new subscription created";
        //     echo "<br>"; 
        // }

        // Single Charges
        // ======================================================================
        // simple charge (charge without invoice)
        // ===================================
        // charge without additional options
        // if($striprCharge = $user->charge(2000,$token)){
        //     echo "charge without additional options";
        //     echo "<br>";
        // }

        // // charge with additional options
        // if($user->charge(2000,$token,['receipt_email'=>$user->email,])
        // ){
        //     echo "charge with additional options";
        //     echo "<br>";
        // }

        // // success and fail
        // try{
        //     if($payment = $user->charge(2000,$token)){
        //         echo "charge success and return payment instance";
        //         echo "<br>";
        //         // print_r($payment);
        //         // echo "<br>";
        //     }
        // }catch(Exception $e){
        //     echo "charge fails and throw an exception";
        //     echo "<br>";
        // }

        // charge with invoice
        // ===================================
        // if($user->invoiceFor("one time fee",2000)){
        //     echo "invoiced";
        // }

        // if( $user->invoiceFor("Stickers",2000,['amount'=>2000,],['tax_percent'=>21,]) ){
        //     echo "invoiced with billing options";
        //     echo "<br>";
        // }
        // 3rd argument: billing options for invoice item (only can use amount parameter, maybe a bug)
        // 4th argument: billing options for invoice itself

        // refunding charges
        // ===================================
        // refunding charge without invoice
        // $payment = $user->charge(2000,$token);
        // echo "payment: ". $payment->id." charged";
        // echo "<br>";

        // if( $user->refund($payment->id) ){
        //     echo "payment: ".$payment->id." refunded";
        //     echo "<br>";
        // }

        // refunding charge with invoice
        // $invoice = $user->invoiceFor("Stickers",2000,['amount'=>2000,],['tax_percent'=>21,]);
        // echo "payment: ". $invoice->payment_intent." charged and invoice created";
        // echo "<br>";

        // if( $user->refund($invoice->payment_intent) ){
        //     echo "payment: ".$invoice->payment_intent." refunded";
        //     echo "<br>";
        // }

        // Invoices
        // ======================================================================
        // if( $invoices = $user->invoices() ){
        //     echo "get user's invoices";
        //     echo "<br>";
        // }

        // if( $invoices_I_P = $user->invoicesIncludingPending() ){
        //     echo "get user's invoices including pending invoices";
        //     echo "<br>";
        // }

        // return view('order.invoice',[
        //     'invoices'=>$invoices,
        //     'invoices_I_P'=>$invoices_I_P,
        // ]);

        // Strong Customer authentication
        // ======================================================================
        // incomplete payment exception
        // try{
        //     $user->newSubscription('Basic','plan_GCrZLyACwh7Cis')->create($token);

        //     if(! $user->hasIncompletePayment('Basic')){
        //         echo "payment complete";
        //         echo "<br>";
        //     }else{
        //         echo "payment complete";
        //         echo "<br>";
        //     }
        //     if(! $user->subscription('Basic')->hasIncompletePayment()){
        //         echo "payment complete";
        //         echo "<br>";
        //     }

        // }catch(IncompletePayment $exception){

        //     // payment confirmation page default in Cashier (測試模式下似乎不可用)
        //     return redirect()->route(
        //         'cashier.payment',
        //         [$exception->payment->id,'redirect'=>route('order.get'),]
        //     );
        // }

        // Testing 
        // ======================================================================
        // Sending Mail
        $user = $request->user();
        $order = $user->subscription('Basic');

        // Mail::to($user)
        //     ->cc($user)
        //     ->bcc($user)
        //     ->send(new OrderShipped_test($order));

        // Rendering Mailables
        // return (new OrderShipped_test($order))->render();
        // return (new OrderShipped_test($order));

        // Queueing Mail

        // Mail::to($request->user())
        // ->cc($user)
        // ->bcc($user)
        // ->queue(new OrderShipped_test($order));

        // echo now();
        // echo "<br>";
        // $when = now()->addMinutes(10);
        // echo $when;

        // Mail::to($request->user())
        // ->cc($user)
        // ->bcc($user)
        // ->later($when, new OrderShipped_test($order));

        // $message = (new OrderShipped_test($order))
        //         //    ->onConnection('sqs')
        //            ->onQueue('emails');

        // Mail::to($request->user())
        // ->cc($user)
        // ->bcc($user)
        // ->queue($message);

        // Localizing Mailables
        // Mail::to($user)
        //       ->locale('es')
        //       ->send(new OrderShipped_test($order));

        Mail::to($request->user())
              ->send(new OrderShipped_test($order));

    }

    // Mail
    // ======================================================================
    public function ship(Request $request, $orderId){
        // Sending Mail
        // =============================================================
        $order = order::findOrFail($orderId);

        Mail::to($request->user())->send(new OrderShipped($order));

        // more recipients
        Mail::to($request->user())
              ->cc($moreUsers)
              ->bcc($evenMoreUsers)
              ->send(new OrderShipped($order));

        // Queueing Mail
        // =============================================================
        // Queueing A Mail Message (send in the background)
        Mail::to($request->user())
        ->cc($moreUsers)
        ->bcc($evenMoreUsers)
        ->queue(new OrderShipped($order));

        // Delayed Message Queueing (seems not work)
        $when = now()->addMinutes(10);

        Mail::to($request->user())
        ->cc($moreUsers)
        ->bcc($evenMoreUsers)
        ->later($when, new OrderShipped($order));

        // Pushing To Specific Queues (onConnection method doesn't know what its meaning)
        $message = (new OrderShipped_test($order))
                   ->onConnection('sqs')
                   ->onQueue('emails');

        Mail::to($request->user())
        ->cc($moreUsers)
        ->bcc($evenMoreUsers)
        ->queue($message);

        // Queueing By Default (setting mailable class)

        // Localizing Mailables (can not find out what it work)
        // =============================================================
        Mail::to($request->user())
              ->locale('es')
              ->send(new OrderShipped($order));

        // User Preferred Locales (when you have implemented HasLocalePreference interface in user model, you don't need to call the locale method when sending mails)
        Mail::to($request->user())
              ->send(new OrderShipped($order));

    }

    // Session
    // ======================================================================
    public function show(Request $request, $id){
        // Using The Session
        // =============================================================
        // Retrieving Data
        // ========================================================
        // $value = $request->session()->get('key');
        // echo $value;
        // echo "<br>";

        // $value = $request->session()->get('key','default1');
        // echo $value;
        // echo "<br>";

        // $value = $request->session()->get('key',function(){
        //     return 'default2';
        // });
        // echo $value;
        // echo "<br>";

        // The Global Session Helper
        // $value = session('key');
        // echo $value;
        // echo "<br>";

        // $value = session('key','default');
        // echo $value;
        // echo "<br>";

        // $value = session(['key'=>'value']);
        // echo $value;
        // echo "<br>";

        // Retrieving All Session Data
        // $data = $request->session()->all();
        // print_r($data);
        // echo "<br>";

        // Determining If An Item Exists In The Session
        // $value = session(['key'=>'value','key2'=>null]);

        // if($request->session()->has('key')){
        //     echo "item exists and value is not null";
        //     echo "<br>";
        // }

        // if($request->session()->exists('key2')){
        //     echo "item exists and no matter value is null or not";
        //     echo "<br>";
        // }

        // Storing Data
        // ========================================================
        // $request->session()->put(['put_key'=>'put_value']);
        // echo $request->session()->get('put_key');
        // echo "<br>";

        // session(['global_helper_key'=>'global_helper_value']);
        // echo session('global_helper_key');
        // echo "<br>";

        // // Pushing To Array Session Values
        // $request->session()->push('user.teams','developers');
        // print_r($request->session()->get('user.teams'));
        // echo "<br>";
        
        // // Retrieving & Deleting An Item
        // // $request->session()->put(['key'=>'value']);

        // $value = $request->session()->pull('key','default');
        // echo $value;
        // echo "<br>";

        // Flash Data (data will exists in this time request and next time request, than it will be deleted)
        // ======================================================== 
        $request->session()->flash('status','Task was successful!');
        $value =  $request->session()->get('status');
        echo $value;
        echo "<br>";

        $request->session()->reflash(); // (restart all exist flash data)

        $request->session()->keep(['username','email']); // (restart specific exist flash data)

        // Deleting Data
        // ========================================================
        // $request->session()->forget('status');
        $request->session()->forget(['status','key2']);
        // $request->session()->flush();

        // Regenerating The Session ID
        // ========================================================
        $value = $request->session()->regenerate();

        $session_id = $request->session()->get('_token');
        echo $session_id;
        echo "<br>";

    }


}
