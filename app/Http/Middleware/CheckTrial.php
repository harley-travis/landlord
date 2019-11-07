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

        /**
         * LEFT OFF HERE. 
         * IF THE USERS TRIAL IS OVER THEN REDIRECT THEM TO SIGN UP AGAIN
         * 
         * I NEED TO FIGURE OUT WHAT THE DATE THAT IS SAVED TO THE TRIAL_END COLUMN IN THE USERS TABLE
         * LOOKS LIKE. 
         * 
         * THEN I NEED TO FIGURE OUT HOW TO MATCH THAT SAME DATA 
         * 
         * NEED TO ADD FUNCTIONALITY TO THE END TRIAL BLADE. 
         * 
         * CAPTURE THEIR PAYMENT INFORMATION
         * 
         * UPDATE USERS STRIPE_ID == NULL
         */


         /**
          * need to figure out what to do with the trial. right now the date is left in the database. so no matter what
          * it will always show this end view.
          * need to setup more logic to check. or to remove the trial period all together. 

          * in the add ACH need to remove the ach
          */

        // if the users trial is expired redirect them to add billing information
        if ( ! Auth::user()->onTrial() && Auth::user()->trial_ends_at != null ) {
            return redirect('settings/billing/trial/end');
        }

        return $next($request);
    }
}
