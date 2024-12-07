<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;

class Adminauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        $uri = $request->segment(2);
        $admin_url =  $request->segment(1);

        // if($admin_url !== env('ADMIN_URL', 'null')){


            if($admin_url == '8BNKaINa1FAHm3yrhCKo'){

            if($uri != '' && $uri != 'admin' && $uri != 'adminlogin' &&$uri != 'sendloginotp'){

                if(!Session::get('adminId')){
                    return redirect(env('ADMIN_URL', 'null'));
                }
                return $next($request);
            }else{


                return $next($request);
            }

        }else{
            return $next($request);

        }

    }
}


