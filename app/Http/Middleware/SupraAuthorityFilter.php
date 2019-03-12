<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;
use Closure;
use Session;
class SupraAuthorityFilter
{
   /**
    * 检测是否可以进入Super 
    */
    public function handle($request, Closure $next)
    {   
      if(($admin = (unserialize(GG('admin'))))->super_model == 1 && $admin->id == session('admin_super_id') &&  MDSV($admin->md_super_token,$admin->id) == session('admin_super_token')){
         return $next($request);
       }
        Log::channel('ultra')->warning('试图越权Super!:IP:'.$request->getClientIp().'id:'.$admin->id.'URL:['.$request->url().']');

        session(['admin_user_id' => null]);
        session(['admin_user_token' => null]);
        session(['admin_super_id' => null]);
        session(['admin_super_token' => null]);
       return L('e');
      // return response(['error'=>1,'status'=>404,'message'=>'This page no longer exists'],404)->header('Content-Type', 'text/plain');
       
    }
}
