<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class Checkauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        $uri = $request->segment(1);

        if(setting()->maintanance == 1){

            if($uri != 'undermaintenance'){
               return redirect('undermaintenance');
            }

        }

        $ip = getIP();

        if(ipBlock($ip) > 0){
            // echo '<h3>Your Ip Block</h3>'; die;
            if($uri != 'ipblock'){
                return redirect('ipblock');
             }
        }




        if($uri != '' && $uri != 'signin' && $uri != 'signup' && $uri != 'account_activate'&& $uri != 'aboutus'&& $uri != 'privacyPolicy'&& $uri != 'refundPolicy'&& $uri != 'contactus' && $uri != 'contactmail' && $uri != 'forgetpw' && $uri != 'verify-link' && $uri != 'forgotpassword' && $uri != 'resetPasssubmit' && $uri != 'termsofservice' && $uri != 'resendmailactive' && $uri != 'investPlan' && $uri != 'affiliates' && $uri != 'userotp' && $uri != 'usertfa' && $uri != 'verification' && $uri != 'resendmail' && $uri != 'undermaintenance' && $uri != 'ipblock' && $uri != 'roiUpdate' && $uri != 'binaryTree' && $uri != 'userManualReg' && $uri != 'dailyRoi' && $uri != 'accountActivate' && $uri != 'fetch-data' && $uri != 'truncateTables'){

            if(!Session::get('userId')){

                return redirect('/');
            }


             if($uri != 'logout'){


                if(@userStatus('is_active') == 0 || userStatus('is_active') ==''){
                     return redirect('logout');
                }else if(@userStatus('is_verify') == 0){
                     return redirect('logout');
                }

             }

            return $next($request);
        }else{



            return $next($request);
        }
    }
}
