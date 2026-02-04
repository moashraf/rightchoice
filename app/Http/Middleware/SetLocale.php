<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;
class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

  $langs = array("en", "ar");
       if(in_array($request->segment(1), $langs)){
        app::setLocale($request->segment(1));
       }else{
        app::setLocale('ar'); // default locale
       }
        return $next($request);
    }
}
