<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class IsYou
{
    
    public function handle($request, Closure $next)
    {
        $userId = Crypt::decrypt($request->id);
        

        if($userId && $userId == Auth::user()->id){
            return $next($request);
        }
        else{
            return abort(404);
        }

    }
}
