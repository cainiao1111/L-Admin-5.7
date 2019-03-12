@extends('Admin.A.vessel')
@section('content')
<div class="layui-field-box">
<table class="layui-table">
	 <colgroup>
    <col width="120">
  
    <col>
  </colgroup>
  <tbody>
    <tr>
      <td>名称</td>
      <td>{{$b['r']->name}}</td>
    </tr>
    <tr>
      <td>E-name</td>
      <td>{{$b['r']->e_name}}</td>
   
    </tr>

    @if($b['r']->type != 3)
      <tr>
      <td>图标</td>
      <td><i class="layui-icon {{$b['r']->icon}}"></i></td>
    </tr>
    
    @else
     <tr>
      <td>API</td>
      <td>{{['否','是'][$b['r']->api]}}</td>
    </tr>
     <tr>
      <td>请求类型</td>
      <td>{{$b['r']->req_type}}</td>
    </tr>
      @endif
      <tr>
      <td>描述</td>
      <td>{{$b['r']->account}}</td>
   
    </tr>
      <tr>
      <td>类别</td>
      <td>{{['','权限组','控制器','方法'][$b['r']->type]}}</td>
   
    </tr>
      <tr>
      <td>权重</td>
      <td>{{$b['r']->weight}}</td>
   
    </tr>
      <tr>
      <td>是否显示</td>
      <td>{{['否','是'][$b['r']->none]}}</td>
   
    </tr>
   @if($b['r']->type != 3)
      <tr>
      <td>所属组</td>
      <td>{{$b['r']->fname?$d['r']->fname:'顶级'}}</td>
   
    </tr>
    
      <tr>
      <td>拥有方法</td>
      <td>
  <table class="layui-table" lay-size="sm">
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
     <th>名称</th>
     <th>E-name</th>
     <th>是否显示</th>
     <th>API</th>
     <th>ID</th>
     <th>URLhash</th>
     <th>请求类型</th>
    </tr> 
  </thead>
  <tbody>
  	
  	@foreach(getYield(json_decode($b['r']->content)) as $k => $v)
    <tr>
      <td>{{$v->k}}</td>
      <td>{{$v->v}}</td>

      <td>{{isset($v->n)?'是':'否'}}</td>
       <td>{{isset($v->api)?'是':'否'}}</td>
        <td>{{isset($v->id)?'是':'否'}}</td>
         <td>{{isset($v->hash)?'是':'否'}}</td>
      <td>{{$v->req}}</td>
    </tr>
	@endforeach
  </tbody>
</table>
      	
      
      	
      	
      </td>  
    </tr>
    @endif
      <tr>
      <td>状态</td>
      <td>{{['停用','正常'][$b['r']->state]}}</td>

    </tr>
       <tr>
      <td>创建时间</td>
      <td>{{$b['r']->created_at}}</td>

    </tr>
       <tr>
      <td>更新时间</td>
      <td>{{$b['r']->updated_at}}</td>

    </tr>
  </tbody>
</table>
</div> 
@endsection
