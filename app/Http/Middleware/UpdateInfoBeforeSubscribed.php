<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateInfoBeforeSubscribed
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
        if ((Auth::user()->height == '' || Auth::user()->height == 0.00) || Auth::user()->dress == '' || Auth::user()->age == '') {
            return redirect(route('edit.profile'))->with('err', 'Please update your state, city, gender, age, height and dress size to subscribe and participate contest.');
        }
        return $next($request);
    }
}
