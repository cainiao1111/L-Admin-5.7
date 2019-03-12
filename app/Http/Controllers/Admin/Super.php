<?php

namespace App\Http\Controllers\Admin;
use  App\Http\Controllers\Admin\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use App\Http\Model\Admin\AdminMode as Mode;
use Illuminate\Support\Facades\Storage;
class Super extends A
{	
     private function rule($request,$bool = false){

        $data = 
        [
         'c'=>['required'=>['密码不能为空!'],'min:6'=>['密码最小长度为6位!','string']]
        ];
        return ValidationRules($data,$request);
    }

	function quit(){
		session(['admin_super_id' => null]);
    	session(['admin_super_token' => null]);
    	return redirect(url('admin'))->with('message','超级模式退出!');
	}
	function update(Request $r){
        $validator = $this->rule($r);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
		$r = $r->only('a','b','c');
		$super_pass = ($admin = unserialize(GG('admin')))->super_pass;
		// if(MDSP($r['a']) != $super_pass){
		// 	return back()->with('message','密码错误!');
		// }
		// if($r['b'] != $r['c']){
		// 	return back()->with('message','两次密码不一致!');
		// }
		// if( Mode::where('id','=',$admin->id)->update(['super_pass'=>MDSP($r['c'])])){
		// 	return back()->with('message','修改成功!');
		// }
		// return back()->with('message','修改失败');
        
        switch (true) {
            case MDSP($r['a']) != $super_pass:
                $message = '密码错误!';
                break;
            case $r['b'] != $r['c']:
                 $message = '两次密码不一致!';
                break;
            case  Mode::where('id','=',$admin->id)->update(['super_pass'=>MDSP($r['c'])]):
                 $message = '修改成功!';
                break;
            default:
                 $message = '修改失败!';
                break;
        }

        return  back()->with('message',$message);
	}
	function edit(){
		return V();
	}

	function _init()
    {
        $this->middleware(['SuperModel','signed'])->only(['index','login']);
    }


    function index(){
    	session(['admin_super_id' => null]);
    	session(['admin_super_token' => null]);
    	return V();
    }
    function login(Request $r){
    	$b = $r->input('b');
    	if(MDSP($b) == GG('pass')){
    		 //验证通过,存储凭证,每次验证
    		session(['admin_super_id' =>($id = session('admin_user_id'))]);
    		$mt = uniqid(mt_rand(1000,9999));
    		$update['md_super_token'] = $mt;
    		$mdv = MDSV($mt,$id);
    		Mode::where('id','=',$id)->update($update);
    		session(['admin_super_token' => $mdv]);
            Log::channel('login_true')->info('登录成功!:IP:'.$r->getClientIp().'登录Super',['id'=>session('admin_user_id')]);
    		return redirect(url('admin'))->with('message','Super模式开启!');
    	}
        Log::channel('login_false')->error('登录失败!:IP:'.$r->getClientIp().'登录Super',['id'=>session('admin_user_id')]);
    	return back()->with('message','登录失败!');
    }
    function logs(){
       $a = new \Rap2hpoutre\LaravelLogViewer\LogViewerController;
       return $a->index();
    }
    function upload_files(Request $request){

      // $row = Storage::disk('env')->get('1.env');
       $row = Storage::disk('public')->allDirectories('img');     
       $files = [];
       $a = $b = '';
       foreach(getYield($row) as $v){
            $arr = explode("/", $v);
            $num = count($arr);  
            if($num == 2){
                $files[$arr[1]]['name'] = $arr[1];  
            }else if($num == 3){
                $files[$arr[1]]['list'][] = $arr[2];
                $a = $arr[1];
                $b = $arr[2];
            }
       }
       $search['a'] = $request->input('a',$a);
       $search['b'] = $request->input('b',$b);
       $directory = 'img/'.$search['a'] .'/'.$search['b']; 
       $images = Storage::disk('public')->allFiles($directory);
       $size = json_decode(Storage::disk('config')->get('system.json'))->image_upload_size;
       return V(['files'=>json_encode(array_values($files)),'search'=>$search,'images'=>$images,'size'=>$size]);
    }
    function upload(Request $request,$a,$b){
        $file = $request -> file('file');
        if ($file -> isValid()) {
            //获取原文件名
            $originalName = $file -> getClientOriginalName();
            //扩展名
            $ext = $file -> getClientOriginalExtension();
            //文件类型
            $type = $file -> getClientMimeType(); 
            //临时绝对路径
            $realPath = $file -> getRealPath();

            $filename = 'img/'.$a.'/'.$b. '/' . uniqid(microtime(true).chr(mt_rand(65,90))) . '.' . $ext;
            $bool = Storage::disk('public') -> put($filename, file_get_contents($realPath));
            $return = ['error'=>0,'images'=> $filename];
            Log::channel('upload')->info('S-上传文件  磁盘:[public]',['id'=>session('admin_user_id'),'ip'=>$request->getClientIp(),$return]);
            return $return;
        }
        Log::channel('upload')->info('S-上传文件  磁盘:[public]',['id'=>session('admin_user_id'),'ip'=>$request->getClientIp(),'error'=>'失败!']);
        return ['error'=>1];
    }
    function delete_image(Request $r){
        $url = $r->input('value','');
        $d = Storage::disk('public')->delete($url);
        $error = $d?0:1;
        Log::channel('upload')->info('S-删除文件 URL :['.$url.'] 磁盘:[public]',['id'=>session('admin_user_id'),'ip'=>$r->getClientIp(),'error'=>$error]);
        return ['error'=>$error];
    }
    function artisan(){
        if(session('admin_user_id') == 1){
            return V();
        }
        return L();        
    }
    function artisan_api(Request $r){ 
        if(session('admin_user_id') != 1){
            return L();
        }
        $type = $r->input('type','0');
        $e = 'php ../artisan ';
        if($type != 1 ){
            $index = $r->input('index','x');
            switch ($index) {
                case 0:
                   $e .=' route:cache';
                    break;
                case 1:
                    $e .=' route:clear';
                    break;
                case 2:
                    $e .=' config:cache';
                    break;
                case 3:
                    $e .=' config:clear';
                    break;
                default:
                    return null;
                    break;
            }

        }else{
            $e .= $r->input('value','date');
        }
        Log::channel('artisan')->info('执行命令 - [ '.$e.' ]',['ip'=>$r->getClientIp(),'admin'=>session('admin_user_id')]);
         return `$e`;
        
    }
    function route(){
        $code = "Route::middleware('admin','AuthorityFilter')->namespace('Admin')->group(function(){\r";
                $rec = ['index','create','store','show','edit','update','destroy'];
        $r = DB::table('a_permissions')->where(['state'=>1])->where('type','<>',3)->select('e_name','content')->get();
        foreach(getYield($r) as $v){
        $c = json_decode($v->content);
        $only = [];
        foreach($c as $k => $vv){
            if(in_array($vv->v, $rec)){
                $only[]= '"'.$vv->v.'"';
                unset($c[$k]);
            }
        }
        $num = count($only);
        $only = implode(",", $only);
        if(strlen($only)>1 && $num<7){
        $code .= "Route::resource(\"".$v->e_name."\",\"".$v->e_name."\",['parameters' => [\"".$v->e_name."\"=> 'id'],'only'=>[".$only."]]);\r";
        }else if($num == 7){
         $code .= "Route::resource(\"".$v->e_name."\",\"".$v->e_name."\",['parameters' => [\"".$v->e_name."\"=> 'id']]);\r";
        }
        foreach($c as $vvv){
            $name = $v->e_name.'/'.$vvv->v;
            if(isset($vvv->api)){
                $name = 'adminapi/'.$name;
            }

            if(isset($vvv->id)){
                $name .='_{id}';
            }
            if(isset($vvv->hash)){
            $hash = $v->e_name.'.'.$vvv->v;
            $code .= "Route::".$vvv->req."(\"".$name."\",\"".$v->e_name."@".$vvv->v."\")->name(\"".$hash."\")->middleware('signed');\r";      
        }else{
             $code .= "Route::".$vvv->req."(\"".$name."\",\"".$v->e_name."@".$vvv->v."\");\r";   
        }



        }
    }

        $code .="});";
        return V($code);
    }

    function basis(){
        $r = json_decode(Storage::disk('config')->get('system.json'),true);
        return V($r);
    }

    function basis_save(Request $request){
        $data = $request->only('admin_name','ip','admin_foot','admin_login_name','admin_pass','admin_s_pass','image_upload_size');
        $data['ip'][1] = explode('-',$request->input('a',''));
        $data['ip'][2] = explode('-',$request->input('b',''));
        $data = json_encode($data);
        Storage::disk('config')->put('system.json', $data);
        Log::channel('setconfig')->info('修改配置文件 - system.json',['ip'=>$request->getClientIp(),'admin'=>session('admin_user_id'),'data'=>$data]);
        return back()->with('message','保存成功!');
    }
}
