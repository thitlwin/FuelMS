<?php

namespace PowerMs\Http\Middleware;

use Closure;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth_key=$request->header('ApiKey');        
        $res = \DB::table('users')->where('api_key',$auth_key)->pluck('api_key');  
        // dd($auth_key);
        if(count($res)>0)
            return $next($request);
        return \Response::json(['status'=>['message'=>'Unauthorized access.','code'=>403]]);
    }
}