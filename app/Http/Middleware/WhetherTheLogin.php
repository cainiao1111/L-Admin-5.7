<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use Illuminate\Support\Facades\Log;
use App\Http\Model\Admin\AdminMode as Mode;
/**
 * 验证是否登录
 */
class WhetherTheLogin
{
    public function handle($request, Closure $next)
    {   	 
    	 //每次查询验证
    	 if((Session::has('admin_user_id') && isset(($m = Mode::first_admin(['a.id'=>session('admin_user_id')]))->id) && session('admin_user_token')==MDV($m->md_token,$m->id)) && ($m->super_model == 1 || ($m->bstate == 1 && $m->state == 1))) {
    	 	G('admin',serialize($m));
			G('mcm',getCurrentAction());
			return $next($request);   	 	
    	 }

		Log::channel('ultra')->warning('异常访问!状态:未登录!:IP:'.$request->getClientIp().'URL:['.$request->url().']');
	    session(['admin_user_id' => null]);
        session(['admin_user_token' => null]);
        session(['admin_super_id' => null]);
        session(['admin_super_token' => null]);
	   return L('e');
       // return response(['error'=>1,'status'=>404,'message'=>'This page no longer exists'],404)->header('Content-Type', 'text/plain');
    }
}
