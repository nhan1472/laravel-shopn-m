<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check())
        {

            return redirect('/');
           
        }
        else{
            if(Auth::user()->role==0||Auth::user()->role==2)
            {
            return $next($request);
            }
            return redirect(route('cart.index'))->with('success', 'bạn đang ở quyền quản trị không đặt hàng được');
        }
    }
}
