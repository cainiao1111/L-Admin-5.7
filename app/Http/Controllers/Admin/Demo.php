<?php

namespace App\Http\Controllers\Admin;
use  App\Http\Controllers\Admin\A;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Model\Admin\Permissions as Model;
use Illuminate\Support\Facades\Storage;
class Demo extends A
{   
    private $_DB = 'demo';
    private $_Log = 'Demo';

    private function rule($request,$bool = false){

        $data = 
        [
        'name' =>['required'=>['名称是必须的'],'unique:demo'=>['名称已存在!']],
        'state'=>['nullable'=>['状态可以为空'],'regex:@^1$@'=>['状态不正确']],
        'account'=>['required'=>['简介是必须的'],'max:255'=>['简介最大长度为255个字符','string']],
        'text'=>['max:1000'=>['内容最大长度为1000个字符','string']]
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
        ->select('a.name','a.order_by','a.state','a.id')
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
    {   $size = json_decode(Storage::disk('config')->get('system.json'))->image_upload_size;
        return V($size);
    }
    //保存
    public function store(Request $r)
    {   
        $validator = $this->rule($r);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $r->only(['name','account','order_by','text','img']);
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
        return V(['r'=>$r]);
    }
    //编辑
    public function edit($id)
    {   
        $size = json_decode(Storage::disk('config')->get('system.json'))->image_upload_size;
        $r = DB::table($this->_DB)->where('id','=',$id)->first();
        if(empty($r->id)){return L();}
        return V(['r'=>$r,'size'=>$size]);
    }
    //更新
    public function update(Request $r, $id)
    {
        $data = $r->only(['name','account','order_by','text','img']);
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
    function deletedatas(Request $r){
      $value  = $r->input('value',[]);
      $message = DB::table($this->_DB)->whereIn('id',$value)->delete();
      delete_log($r,$message,$this->_Log,$this->_DB,'list:'.implode('-|-',$value));
      return ['error'=> $message?0:1];
    }

     function state(Request $r,$id){
         $value  = $r->input('value',1);
         $message = DB::table($this->_DB)->where('id',$id)->update(['state'=>$value]);
         update_log($r,$message,$this->_Log,$this->_DB,['state'=>$value],$id);
         return ['error'=> $message?0:1];
    }
    function orderby(Request $r,$id){
          $value  = $r->input('value',1);
         $message = DB::table($this->_DB)->where('id',$id)->update(['order_by'=>$value]);
         update_log($r,$message,$this->_Log,$this->_DB,['order_by'=>$value],$id);
         return ['error'=> $message?0:1];
    }
}
