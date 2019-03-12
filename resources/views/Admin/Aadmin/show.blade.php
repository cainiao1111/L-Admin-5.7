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
      <td>账号</td>
      <td>{{$b->account}}</td>
    </tr>
     <tr>
      <td>姓名</td>
      <td>{{$b->username}}</td>
    </tr>
     <tr>
      <td>昵称</td>
      <td>{{$b->nickname}}</td>
    </tr>
    
     <tr>
      <td>角色</td>
      <td>{{$b->bname}}</td>
    </tr>
      <tr>
      <td>状态</td>
      <td>{{['停止','正常'][$b->state]}}</td>
    </tr>
    <tr>
       <tr>
      <td>创建时间</td>
      <td>{{$b->created_at}}</td>

    </tr>
       <tr>
      <td>更新时间</td>
      <td>{{$b->updated_at}}</td>

    </tr>
  </tbody>
</table>
</div> 
@endsection
