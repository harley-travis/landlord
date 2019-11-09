<?php

namespace App\Http\Middleware;

use Auth;
use App\User;
use Closure;

class CheckTrial
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        /**
         * NEED TO FIGURE OUT WHAT OT DO WITH THE TENENT. THIS WILL ALWWAYS BE NUILIL IF YOURE A TENATN
         */
        // if the user doesn't not have a stripe account
        // enforce the user to enable their free 14 day trial
        if ( Auth::user()->stripe_id === null ) {
            return redirect('settings/billing/trial/begin');
        }

        // if the users trial is expired redirect them to add billing information
        if ( ! Auth::user()->onTrial() && Auth::user()->trial_ends_at != null ) {
            return redirect('settings/billing/trial/end');
        }

        return $next($request);
    }
}
