<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class PlanController extends Controller
{
    // 綁定中介層
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $plans = Plan::all();

        return view('plan.index',compact('plans'));
    }

    public function show(Request $request,Plan $plan){

        return view('plan.show',compact('plan'));
    }
}
