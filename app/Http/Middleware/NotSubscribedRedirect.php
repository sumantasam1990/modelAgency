<?php

namespace App\Http\Middleware;

use App\Models\Payment;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotSubscribedRedirect
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
        if (Auth::user()->subscribed !== 1 || Payment::where('user_id', Auth::user()->id)->where('end_date', '<', Carbon::today()->format('Y-m-d'))->count('id') > 0) {
            return redirect(route('subscription.now'));
        }
        return $next($request);
    }
}
