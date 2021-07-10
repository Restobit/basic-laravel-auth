<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AcceptedUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (env('MUST_ACCEPT_USER_REGISTRATION') === false) {
            return $next($request);
        }

        $prevUrlArr = explode('/', URL::previous());

        if (isset($prevUrlArr[3], $prevUrlArr[4]) && $prevUrlArr[3] === 'email' && $prevUrlArr[4] === 'verify' && $prevUrlArr[5] == Auth::user()->id) {
            //$request->session()->flush();
            return redirect('/login')->with(['status' => __('Sikeres aktiválás, kérjük várjon, míg elfogadják a regisztrációját.')]);
        }
        if(Auth::user() && !Auth::user()->email_verified_at)
        {
            return redirect('/')->with(['status' => __('Kérjük aktiválja a regisztrációt a hitelesítő e-mail segítségével.')]);
        }

        if(Auth::user() && Auth::user()->email_verified_at && Auth::user()->accepted === 0)
        {
            $request->session()->flush();
            return redirect('/login')->with(['status' => __('Kérjük várjon, míg elfogadják a regisztrációját.')]);
        }

        if (Auth::user() && Auth::user()->accepted === 1) {
            return $next($request);
        }

        $request->session()->flush();
        return redirect('/login')->with(['status' => __('')]);
    }
}
