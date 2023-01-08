<?php

namespace App\Http\Middleware;

use Closure;

class StringFilter
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
        $values = $request->all();
        $fliter_string = ["<script>","</script>","<?php","?>","<?","<?="];

        str_ireplace($fliter_string,'',$values,$count);
  
        if($count != 0){
            return redirect()->back();
        }else{
            return $next($request);
        }

        return $next($request);
    }
}
