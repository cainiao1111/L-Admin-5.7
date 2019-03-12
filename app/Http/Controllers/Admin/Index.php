<?php
namespace App\Http\Controllers\Admin;
use  App\Http\Controllers\Admin\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Model\Admin\AdminMode as Mode;
use App\Http\Model\Admin\Permissions as PM;
use Illuminate\Support\Facades\Storage;
class Index extends A
{	
	private function Mrule($request,$bool = false){

        $data = 
        [
         'c'=>['required'=>['密码不能为空!'],'min:6'=>['密码最小长度为6位!','string']]
        ];
        return ValidationRules($data,$request);
    }

	private function rule($request,$bool = false){

        $data = 
        [
        'username'=>['required'=>['姓名不能为空!'],'max:10'=>['姓名最大长度为10位!','string']],
        'nickname'=>['required'=>['昵称不能为空!'],'max:10'=>['昵称最大长度为10位!','string']]
        ];
        return ValidationRules($data,$request);
    }

	function _init(){
		 $this->middleware(['signed'])->only(['editU','updateU']);
	}
	function editU(){

		// Log::channel('debug')->info('Something happened!',['id'=>1]);
		G('r',unserialize(GG('admin')));
		return V();
	}
	function updateU(Request $r){
		$validator = $this->rule($r);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

		$r = $r->only('username','nickname');
		if( Mode::where('id','=',session('admin_user_id'))->update($r)){
			return back()->with('message','修改成功!');
		}
		return back()->with('message','修改失败');
	}
	function edit(){
		return V();
	}
	function update(Request $r){
		$validator = $this->Mrule($r);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

		$r = $r->only('a','b','c');
		$password = ($admin = unserialize(GG('admin')))->password;
		// if(MDP($r['a']) != $password){
		// 	return back()->with('message','密码错误!');
		// }
		// if($r['b'] != $r['c']){
		// 	return back()->with('message','两次密码不一致!');
		// }
		// if( Mode::where('id','=',$admin->id)->update(['password'=>MDP($r['c'])])){
		// 	return back()->with('message','修改成功!');
		// }

		switch (true) {
			case MDP($r['a']) != $password:
				$message = '密码错误!';
				break;
			case $r['b'] != $r['c']:
				$message = '两次密码不一致!';
				break;
			case Mode::where('id','=',$admin->id)->update(['password'=>MDP($r['c'])]):
				$message = '修改成功!';
				break;
			default:
				$message = '修改失败!';
				break;
		}
		return back()->with('message',$message);
		// return back()->with('message','修改失败');
	}
	// function quit(){
	// 	session(['admin_user_id' => null]);
 //    	session(['admin_user_token' => null]);
 //    	session(['admin_super_id' => null]);
 //    	session(['admin_super_token' => null]);
 //    	return ['error'=>0,'message'=>'successful exit!'];
	// }
    function index(){
    	$super = unserialize(GG('admin'))->super_model;
    	$p = PM::where(['state'=>1,'none'=>1])->orderBy('weight','desc')->where('type','<>',3)->get();
    	$r = json_decode(Storage::disk('config')->get('system.json'));
    	return V(['super'=>$super,'p'=>$p,'r'=>$r]);
    }
    function platformData(){

    	return V();
    }
    function img_upload(Request $request){
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

            $filename = 'img/'.date('Y/m/'). uniqid(microtime(true).chr(mt_rand(65,90))) . '.' . $ext;
            $bool = Storage::disk('public') -> put($filename, file_get_contents($realPath));
            $return = ['code'=>0,'location'=>'./storage/'.$filename];
            Log::channel('upload')->info('上传文件  磁盘:[public]',['id'=>session('admin_user_id'),'ip'=>$request->getClientIp(),$return]);
            return $return;
        }
        Log::channel('upload')->info('上传文件  磁盘:[public]',['id'=>session('admin_user_id'),'ip'=>$request->getClientIp(),'error'=>'失败!']);
        return ['error'=>1];
    }
    function picture_history(Request $request,$t,$dom){
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
       return V(['files'=>json_encode(array_values($files)),'search'=>$search,'images'=>$images,'t'=>$t,'dom'=>$dom]);
    }
}
