<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class SubscriptionController extends Controller
{
    // 綁定中介層
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(Request $request,Plan $plan){
        $plan = plan::findOrFail($request->get('plan'));
        $request->user()->newSubscription('default',$plan->stripe_plan)->create($request->stripeToken);

        return redirect()->route('home')->with('success','Your plan subscribed successfully');
    }
}
