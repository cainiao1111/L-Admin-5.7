<?php

namespace App\Http\Controllers\Admin;
use  App\Http\Controllers\Admin\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Storage;
class Aadmin extends A
{   
    private $_DB = 'a_admin';
    private $_Log = '管理员管理';
    private $_DBT = 'a_role';
    private function rule($request,$bool = false){

        $data = 
        [
        'account' =>['required'=>['登录账号不能为空'],'max:16'=>['登录账户最大长度为16位!','string'],'unique:a_admin'=>['登录账号已存在!'],'min:4'=>['登录账户最小长度为4位!','string']],
        'username'=>['required'=>['姓名不能为空!'],'max:10'=>['用户名最大长度为10位!','string']],
        'nickname'=>['required'=>['昵称不能为空!'],'max:10'=>['昵称最大长度为10位!','string']],
        'password'=>['required'=>['密码不能为空!'],'min:6'=>['密码最小长度为6位!','string']],
        'state'=>['nullable'=>['状态可以为空'],'regex:@^1$@'=>['状态不正确']],
        'r_id'=>['nullable'=>['状态可以为空'],'regex:@^[0-9]+$@'=>['角色不正确']]
        ];

        if(true){
           $data = array_except($data, ['account','password']);
        }
        return ValidationRules($data,$request);
    }
    //列表
    public function index(Request $r)
    {   
        $search['pag'] = $r->input('pag',10);
        $search['order_value'] = $r->input('order_value','ASC');
        $search['order_name'] = $r->input('order_name','account');
        $search['search_value'] = $r->input('search_value','');
        $search['search_name'] = $r->input('search_name','account');
        $row = DB::table($this->_DB.' as a')
        ->leftJoin($this->_DBT.' as b','a.r_id','=','b.id')
        ->select('a.*','b.name as bname')
        ->orderBy('a.'.$search['order_name'],$search['order_value'])
        ->where('a.super_model',0)
        ->where('a.id','<>',1)
        ->where('a.none',1);
        if(!empty($search['search_value'])){
            $row->where('a.'.$search['search_name'],'like','%'.$search['search_value'].'%');
        }
        $row = $row->paginate($search['pag']);
        $row->appends($search);
        return V(['row'=>$row,'search'=>$search]);
    }
    //创建
    public function create()
    {
      $row = DB::table($this->_DBT)->where('state','=',1)->select('id','name')->get();
      return V(['row'=>$row]);
    }
    //保存
    public function store(Request $request)
    {
  
     $validator = $this->rule($request);
     if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
     }
     $data = $request->only('account','nickname','username');
     $data['password'] = MDP($request->input('password'));
     $data['super_pass'] = MDSP('S'.$request->input('password'));
     $data['updated_at'] = $data['created_at'] = date('Y-m-d H:i:s');
     $data['state'] = $request -> input('state',0);
     $data['none'] = 1;
     $data['super_model'] = 0;
     $data['r_id'] = $request -> input('r_id',0);
     $message = DB::table($this->_DB)->insertGetId($data);
     create_log($request,$message,$this->_Log,$this->_DB,$data);
     return AB($message);
    }
    //查看
    public function show($id)
    {
       $r = DB::table($this->_DB.' as a')
        ->leftJoin($this->_DBT.' as b','a.r_id','=','b.id')
        ->select('a.*','b.name as bname')
        ->where('a.id',$id)
        ->where('a.id','<>',1)
        ->where('a.super_model',0)
        ->where('a.none',1)
        ->first();
        if(empty($r->id)){return L();}

        return V($r);
    }
    //编辑
    public function edit($id)
    {
        $r = DB::table($this->_DB)
        ->where('id',$id)
        ->where('id','<>','1')
        ->where('id','<>',session('admin_user_id'))
        ->where('super_model',0)
        ->where('none',1)
        ->first();
        if(empty($r->id)){return L();}
        $row = DB::table($this->_DBT)->where('state','=',1)->select('id','name')->get();
        return V(['r'=>$r,'row'=>$row]);
    }
    //更新
    public function update(Request $request, $id)
    {
           $validator = $this->rule($request,true);
            if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
            }
        $data = $request->only('nickname','username');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['state'] = $request -> input('state',0);
        $data['none'] = 1;
        $data['super_model'] = 0;
        $data['r_id'] = $request -> input('r_id',0);
        $message = DB::table($this->_DB)
        ->where('id','=',$id)
        ->where('id','<>','1')
        ->where('id','<>',session('admin_user_id'))
        ->where('super_model',0)
        ->where('none',1)
        ->update($data);
        update_log($request,$message ,$this->_Log,$this->_DB,$data,$id);
        return back()->with('message',$message?'更新成功!':'更新失败!');


    }

    //删除
    public function destroy(Request $r,$id)
    {
      $message = DB::table($this->_DB)
      ->where('id','=',$id)
      ->where('id','<>','1')
      ->where('id','<>',session('admin_user_id'))
      ->where('super_model',0)
      ->where('none',1)
      ->delete();
      delete_log($r,$message,$this->_Log,$this->_DB,$id);
      return ['error'=> $message?0:1];
    }

     function state(Request $r,$id){
         $value = $v = $r->input('value',1);
         $message = DB::table($this->_DB)
         ->where('id',$id)
         ->where('id','<>','1')
         ->where('id','<>',session('admin_user_id'))
         ->where('super_model',0)
         ->where('none',1)
         ->update(['state'=>$value]);
         update_log($r,$message,$this->_Log,$this->_DB,['state'=>$value],$id);
         return ['error'=> $message?0:1];
    }

    function resetpass(Request $r,$id){
         $sto = json_decode(Storage::disk('config')->get('system.json'));
         $update = [
         'password'=>MDP($sto->admin_pass),
         'super_pass'=>MDSP($sto->admin_s_pass)
         ];
         $message = DB::table($this->_DB)
         ->where('id',$id)->where('id','<>','1')
         ->where('id','<>',session('admin_user_id'))
         ->where('super_model',0)
         ->where('none',1)
         ->update($update);
         update_log($r,$message,$this->_Log,$this->_DB,$update,$id);
         return ['error'=> $message?0:1];
    }
}
