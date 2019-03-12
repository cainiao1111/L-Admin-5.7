<?php
namespace App\Http\Controllers\Admin;
use  App\Http\Controllers\Admin\A;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Admin\Permissions as Model;
class Permissions extends A
{   
    private $_Log = '权限管理S';
    private $_DB = 'a_permissions';
    private $_name_of_ban = ['A','Index','Login','Part','Permissions','Super','Xadmin','Error'];
    private function rule($request,$bool = false){

        $data = 
        [
         'name'=>['required'=>['名称不能为空!']],
         'e_name'=>['required'=>['e_name不能为空!']],
         'weight'=>['required'=>['权重不能为空!'],'regex:@^[0-9]{1,4}$@'=>['权重必须为数字0-9999!']],
         'type'=>['required'=>['类型是必须的!'],'regex:@^[1-3]{1}$@'=>['类型不正确!']],
         'fid'=>['required'=>['fid是必须的!'],'regex:@^[0-9]+$@'=>['fid数值类型错误!']]
        ];
        return ValidationRules($data,$request);
    }

    //列表
    public function index(Request $r)
    {
        
        return V(['r'=>Model::orderBy('weight','desc')->get()]);
    }
    //创建
    public function create()
    {   
       $row = Model::where(['state'=>1])
        ->select('id','name','e_name','type','none','req_type','api')
        ->orderBy('weight','desc')
        ->get();
        return V(['row'=>$row]);
    }
    //保存
    public function store(Request $request)
    {   
       $validator = $this->rule($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $r = $request->only('name','type','fid','weight','e_name','none','account','icon','api','req_type');
        $r['e_name'] = $r['type'] == 3?strtolower($r['e_name']):ucfirst($r['e_name']);
        if(in_array($r['e_name'],$this->_name_of_ban)){
             return back()->with('message','e_name不能为'.implode('*',$this->_name_of_ban))->withInput();
        }

        $r['state'] = $request -> input('state',0);
        $keys =$r['type'] == 3?[]: $request -> input('content',[]);
        //去掉键名
        $keys = array_values($keys);
        $r['content'] = json_encode($keys);  
        $r['updated_at'] =$r['created_at'] = date('Y-m-d H:i:s');
        $message = DB::table($this->_DB)->insertGetId($r);
        create_log($request,$message,$this->_Log,$this->_DB,$r);
        return AB($message);
    }
    //查看
    public function show($id)
    {
        $r = Model::from('a_permissions as p')->select('p.*','f.name as fname')->where('p.id','=',$id)->leftJoin('a_permissions as f','f.id','=','p.fid')->first();
        if(empty($r->id)){return L();}
        return V(['r'=>$r]);
    }
    //编辑
    public function edit($id)
    {   
        $r=Model::from('a_permissions as p')->select('p.*','f.name as fname')->where('p.id','=',$id)->leftJoin('a_permissions as f','f.id','=','p.fid')->first();
        if(empty($r->id)){return L();}
        $row = Model::orderBy('weight','desc')->where(['type'=>1])->select('name','id')->get();
        return V(['r'=>$r,'row'=>$row]);
    }
    //更新
    public function update(Request $request, $id)
    {   
        $validator = $this->rule($request);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $r = $request->only('name','type','fid','weight','e_name','none','account','icon');
        $r['e_name'] = $r['type'] == 3?strtolower($r['e_name']):ucfirst($r['e_name']);
        if(in_array($r['e_name'],$this->_name_of_ban)){
             return back()->with('message','e_name不能为'.implode('*',$this->_name_of_ban))->withInput();
        }
         $r['state'] = $request -> input('state',0);
         $keys =$r['type'] == 3?[]: $request -> input('content',[]);
         $keys = array_values($keys);
         $r['content'] = json_encode($keys); 
        $message = Model::where('id',$id)->update($r);
        update_log($request,$message,$this->_Log,$this->_DB,$r,$id);
        return back()->with('message', $message?'更新成功!':'更新失败!');

    }
    function state(Request $r,$id){
         $value = $v = $r->input('value',1);
         $message = Model::where('id',$id)->update(['state'=>$value]);
          update_log($r,$message,$this->_Log,$this->_DB,['state'=>$value],$id);
         return ['error'=> $message?0:1];
    }
    function weight(Request $r,$id){
         $value = $v = $r->input('value',1);
         $message = Model::where('id',$id)->update(['weight'=>$value]);
         update_log($r,$message,$this->_Log,$this->_DB,['weight'=>$value],$id);
         return ['error'=> $message?0:1];
    }
    function none(Request $r,$id){
         $value = $v = $r->input('value',1);
         $message = Model::where('id',$id)->update(['none'=>$value]);
         update_log($r,$message,$this->_Log,$this->_DB,['none'=>$value],$id);
         return ['error'=> $message?0:1];
    }

}
