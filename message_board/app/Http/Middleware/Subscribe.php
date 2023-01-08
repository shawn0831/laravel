<?php

namespace App\Http\Middleware;

use Closure;

class Subscribe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user() && !$request->user()->subscribed('Basic')){
            return redirect('order'); 
            // echo "HELLO";
        }
        return $next($request);
    }
}
