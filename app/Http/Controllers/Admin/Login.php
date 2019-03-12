<?php

namespace App\Http\Controllers\Admin;
use  App\Http\Controllers\Admin\A;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\LoginPost as Post;
use App\Http\Model\Admin\AdminMode as Mode;
use Illuminate\Support\Facades\Storage;
class Login extends A
{	
	
    function index(){
    	session(['admin_user_id' => null]);
    	session(['admin_user_token' => null]);
    	session(['admin_super_id' => null]);
    	session(['admin_super_token' => null]);
    	return V(json_decode(Storage::disk('config')->get('system.json')));
    }
    function login(Post $r){
    	$validated = $r->validated();
    	$row = $r->only('a','b');
        $m = Mode::first_admin(['a.account'=>$row['a']]);
        $c = json_decode(Storage::disk('config')->get('system.json'),true);
    	if( (isset($m->id) && MDP($row['b'])  == $m->password ) && ($m->super_model == 1 || ($m->bstate == 1 && $m->state ==1 && ($c['ip']['ip_index'] == 0 || ( $c['ip']['ip_index'] == 1 && in_array($r->getClientIp(),$c['ip'][1])) ||  ( $c['ip']['ip_index'] == 2 && !in_array($r->getClientIp(),$c['ip'][2])) ) )) ){    
          //验证通过,存储凭证,每次验证
        session(['admin_user_id' => $m->id]);
        $mt = uniqid(mt_rand(100,999));
        $update['md_token'] = $mt;
        $mdv = MDV($mt,$m->id);
        Mode::where('id','=',$m->id)->update($update);
        session(['admin_user_token' => $mdv]);
        Log::channel('login_true')->info('登录成功!:IP:'.$r->getClientIp().'登录账号:'.$row['a'],['id'=>$m->id]);
        return redirect(url('/admin')); 
    	}
     
        Log::channel('login_false')->error('登录失败!:IP:'.$r->getClientIp().'登录账号:'.$row['a']);
    	return back()->with('message','登录失败!');
    }


}

