<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Log;
class AuthorityFilter
{
   /**
    * 权限认证 || 超级管理认证
    */
    public function handle($request, Closure $next)
    {   
        
        if( (($admin = (unserialize(GG('admin'))))->super_model == 1 && $admin->id == session('admin_super_id') &&  MDSV($admin->md_super_token,$admin->id) == session('admin_super_token')) || ( array_key_exists( (($mcm=GG('mcm'))['controller']),($arr = json_decode($admin->convenient_token,true))) && array_key_exists($mcm['method'],$arr[$mcm['controller']]) &&(G('c_token',$arr)||true) ) ){
           return $next($request);
        }
        Log::channel('ultra')->warning('异常访问!状态:越权!:IP:'.$request->getClientIp().'URL:['.$request->url().']');
        // Session::flush();
        session(['admin_user_id' => null]);
        session(['admin_user_token' => null]);
        session(['admin_super_id' => null]);
        session(['admin_super_token' => null]);
       return L('e');
        
    	//验证是否是超级管理员或有相应的权限
    	// if(!Session::has('super_administrator') && !Session::has('admin_user_id')){
     //         return response(['error'=>1,'message'=>'This page no longer exists'],404)->header('Content-Type', 'text/plain');
     //    }
        // $g = GG('mcm');

        // var_dump($g);

         
    }
}
