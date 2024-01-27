<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class UsersStatusMiddleware
{
    
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->is_active == false){
            Auth::logout();
            return redirect()->route('login.form')->withErrors('You are banned!!!');
            
        }
        return $next($request);
        // else{
        //     return redirect()->route('login.form');
        // }
        
        // return response()->view('errors.noperm');
    }

}
