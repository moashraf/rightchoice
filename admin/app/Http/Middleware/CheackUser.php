<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Request;
use Lang;
use Validator;
use Config;

class CheackUser
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
        
        $locale=app()->getLocale();

        $user = Auth::user();
        // If returned true is meaning this uesr is not logged in
        
        if(!empty($user)){
            if($user->count() ==  0){
                
                session()->flash('success', 'لا يوجد مستخدمين');
                Auth::logout();
                return Redirect::to(Config::get('app.locale').'/login');  
            }
        }else{
            session()->flash('error', 'يجب عليك تسجيل الدخول اولاّ');
            Auth::logout();
            return redirect()->guest(route('login',['locale'=>$locale]));  
        }

        

        return $next($request);
    }
}
