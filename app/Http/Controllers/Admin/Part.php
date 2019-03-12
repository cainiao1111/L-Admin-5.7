<?php

namespace App\Http\Controllers\Admin;
use  App\Http\Controllers\Admin\A;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Admin\Permissions as Model;
class Part extends A
{   
    private $_DB = 'a_role';
    private $_Log = '角色管理S';

    private function rule($request,$bool = false){

        $data = 
        [
        'name' =>['required'=>['角色名称是必须的']],
        'state'=>['nullable'=>['状态可以为空'],'regex:@^1$@'=>['状态不正确']]
        ];
        return ValidationRules($data,$request);
    }
    //列表
    public function index(Request $r)
    {   
        $search['pag'] = $r->input('pag',10);
        $search['order_value'] = $r->input('order_value','ASC');
        $search['order_name'] = $r->input('order_name','id');
        $search['search_value'] = $r->input('search_value','');
        $search['search_name'] = $r->input('search_name','id');
        $row = DB::table($this->_DB.' as a')
        ->select('a.*')
        ->orderBy('a.'.$search['order_name'],$search['order_value']);
        if(!empty($search['search_value'])){
            $row->where('a.'.$search['search_name'],'like','%'.$search['search_value'].'%');
        }
        $row = $row->paginate($search['pag']);
        $row->appends($search);
        return V(['row'=>$row,'search'=>$search]);
        // permissions
    }
    //创建
    public function create()
    { 

    $row = Model::where('state','=',1)->select('name','e_name','id','type','fid','content','icon')->where('type','<>',3)->orderBy('weight','desc')->get();   

    $arr = ConvenientAccess($row);
    return V(['row'=>json_encode(array_values($arr))]);
    }
    //保存
    public function store(Request $r)
    {   
        $validator = $this->rule($r);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $r->only(['name','account','convenient_access']);
        $data['convenient_token'] =  ConvenientTokenToJson($data['convenient_access']);
        $data['convenient_access'] = ConvenientAccessToJson($data['convenient_access']); 
        $data['state'] = $r -> input('state',0);
        $message = DB::table($this->_DB)->insertGetId($data);

        create_log($r,$message ,$this->_Log,$this->_DB,$data);

        return AB($message);
    }
    //查看
    public function show($id)
    {   
        $r = DB::table($this->_DB)->where('id','=',$id)->first();
        if(empty($r->id)){return L();}
        $row = Model::where('state','=',1)->select('name','e_name','id','type','fid','content','icon','account')->where('type','<>',3)->orderBy('weight','desc')->get();

        return V(['r'=>$r,'row'=>$row]);
    }
    //编辑
    public function edit($id)
    {
        $r = DB::table($this->_DB)->where('id','=',$id)->first();
        if(empty($r->id)){return L();}
        $row = Model::where('state','=',1)->select('name','e_name','id','type','fid','content','icon')->where('type','<>',3)->orderBy('weight','desc')->get(); 

        $arr = ConvenientAccess($row,json_decode($r->convenient_access,true));
        return V(['row'=>json_encode(array_values($arr)),'r'=>$r]);
    }
    //更新
    public function update(Request $r, $id)
    {
        $data = $r->only(['name','account','convenient_access']);
        $data['convenient_token'] =  ConvenientTokenToJson($data['convenient_access']);
        $data['convenient_access'] = ConvenientAccessToJson($data['convenient_access']); 
        $data['state'] = $r -> input('state',0);
        $message = DB::table($this->_DB)->where('id','=',$id)->update($data);
        update_log($r,$message ,$this->_Log,$this->_DB,$data,$id);
        return back()->with('message',$message?'更新成功!':'更新失败!');
    }

    //删除
    public function destroy(Request $r,$id)
    {
      $message = DB::table($this->_DB)->where('id','=',$id)->delete();
      delete_log($r,$message,$this->_Log,$this->_DB,$id);
      return ['error'=> $message?0:1];
    }

     function state(Request $r,$id){
         $value  = $r->input('value',1);
         $message = DB::table($this->_DB)->where('id',$id)->update(['state'=>$value]);
         update_log($r,$message,$this->_Log,$this->_DB,['state'=>$value],$id);
         return ['error'=> $message?0:1];
    }
}
