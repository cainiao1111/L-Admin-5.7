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
      <td>描述</td>
      <td>{{$b['r']->account}}</td>
 
 		  <tr>
      <td>拥有权限</td>
      <td>
   @php
   $access = json_decode($b['r']->convenient_access,true);
 
	$state = ['停用','正常'];
	$none = ['否','是'];
	$type = ['','权限组','控制器','方法'];
	$api = ['--','API'];
	 @endphp
	
        <table class="layui-table layui-form">
        <thead>
          <tr>
            <th>栏目名</th>
            <th >E-name</th>
             <th>类别</th>
            <th>图标</th>
            <th>描述</th>
          </tr>
        </thead>
        <tbody class="x-cate">
        @foreach(getYield($b['row']) as $v)
        @if($v->type == 1  && $v->fid == 0  && isset($access[$v->e_name]))
          <tr cate-id='{{$v->id}}' fid='0' >

            <td>
              <i class="layui-icon x-show" status='true'>&#xe623;</i>
              {{$v->name}}
            </td>
            <td>{{$v->e_name}}</td>
             <td>{{$type[$v->type]}}</td>           
            <td><i class="layui-icon {{$v->icon}}"></i></td>     
            <td>{{$v->account}}</td>   
          </tr>
            @foreach(json_decode($v->content) as $kkk => $vvv)
             @if(isset($access[$v->e_name][$vvv->v]))
           <tr cate-id='{{$kkk}}_{{$v->id}}' fid='{{$v->id}}' >

            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;
              ├{{$vvv->k}}
            </td>
            <td>{{$vvv->v}}</td>
             <td>{{$api[$vvv->api]}}/{{$vvv->req}}</td>
             <td>--/--</td>
             <td>--/--</td>

          </tr>@endif
          @endforeach  
          @foreach(getYield($b['row']) as $vv)
          	@if($vv->type == 2 && $vv->fid == $v->id && isset($access[$v->e_name][$vv->e_name]))
          	
			<tr cate-id='{{$vv->id}}' fid='{{$v->id}}' >

            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <i class="layui-icon x-show" status='true'>&#xe623;</i>
              {{$vv->name}}
            </td>
             <td>{{$vv->e_name}}</td>
             	
               <td>{{$type[$vv->type]}}</td>
              <td><i class="layui-icon {{$vv->icon}}"></i></td>
          
           
            <td>{{$vv->account}}</td>

          </tr>
          
          @foreach(json_decode($vv->content) as $kkk => $vvv)
          @if(isset($access[$v->e_name][$vv->e_name][$vvv->v]))
           <tr cate-id='{{$kkk}}_{{$vv->id}}' fid='{{$vv->id}}' >
            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               ├{{$vvv->k}}
            </td>
             <td>{{$vvv->v}}</td>
      
               <td>{{isset($vvv->api)?'Api':'--'}}/{{isset($vvv->id)?'ID':'--'}}/{{isset($vvv->hash)?'URLhash':'--'}}/{{$vvv->req}}</td>
        
            <td>--/--</td>
   
			<td>--/--</td>
   
          </tr>
          @endif
          @endforeach
          @endif
          @endforeach
          
          @elseif($v->type == 2 && $v->fid == 0 && isset($access[$v->e_name]))
             <tr cate-id='{{$v->id}}' fid='0' >

            <td>
              <i class="layui-icon x-show" status='true'>&#xe623;</i>{{$v->name}}
            </td>
            <td>{{$v->e_name}}</td>
            
              <td>{{$type[$v->type]}}</td>
             <td><i class="layui-icon {{$v->icon}}"></i></td>
          
            <td>{{$v->account}}</td>
   
          </tr>
       
             @foreach(json_decode($v->content) as $kkk => $vvv)
             @if(isset($access[$v->e_name][$vvv->v]))
           <tr cate-id='{{$kkk}}_{{$v->id}}' fid='{{$v->id}}' >
            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              ├{{$vvv->k}}
            </td>
            <td>{{$vvv->v}}</td>
   
              <td>{{isset($vvv->api)?'Api':'--'}}/{{isset($vvv->id)?'ID':'--'}}/{{isset($vvv->hash)?'URLhash':'--'}}/{{$vvv->req}}</td>
          
		
    <td>--/--</td>
   
			<td>--/--</td>
 
          </tr>
          @endif
          @endforeach
     
          @endif
          @endforeach

        </tbody>
      </table>
      

      </td>
 
      <tr>
      <td>状态</td>
      <td>{{['停用','正常'][$b['r']->state]}}</td>


  </tbody>
</table>
</div> 
@endsection
