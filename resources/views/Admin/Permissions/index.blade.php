@extends('Admin.A.vessel')
@section('content')
<div class="layui-field-box">
<div class="layui-row">	

<xblock style="position: fixed; top: 0; left: 0; right: 0; z-index:10;">

        <button class="layui-btn" onclick="x_admin_show('添加','{{url($d['mcm']['controller'].'_create')}}')"><i class="layui-icon">&#xe654;</i>添加</button>
       	<button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
<hr />
 </xblock>
 
 <div style="height: 10vh; width: 1vw;"></div>
<!---->

<!--table-->
	@php
	$state = ['停用','正常'];
	$none = ['否','是'];
	$type = ['','权限组','控制器','方法'];
	 @endphp
	
        <table class="layui-table layui-form">
        <thead>
          <tr>

            <th>栏目名</th>
            <th >E-name</th>
             <th style="width:80px;">权重</th>
             <th>类别</th>
            <th>图标</th>
            <th >状态</th>
            <th >是否显示</th>
            <th>描述</th>
            <th width="80">操作</th>
          </tr>
        </thead>
        <tbody class="x-cate">
        @foreach(getYield($b['r']) as $v)
        @if($v->type == 1 && $v->fid == 0)
          <tr cate-id='{{$v->id}}' fid='0' >

            <td>
              <i class="layui-icon x-show" status='true'>&#xe623;</i>
              {{$v->name}}
            </td>
            <td>{{$v->e_name}}</td>
            	<td><input type="text" maxlength="4" data-id="{{$v->id}}" value="{{$v->weight}}" placeholder="权重" lay-filter="order_by" class="layui-input order_by">
            </td>
             <td>{{$type[$v->type]}}</td>
            <td><i class="layui-icon {{$v->icon}}"></i></td>
            <td>
              <input type="checkbox" data-id="{{$v->id}}" lay-filter="state" name="state" @if($v->state == 1) checked="checked" @endif  lay-skin="switch"   lay-text="正常|停用">
            </td>
            <td>
              <input type="checkbox" data-id="{{$v->id}}" lay-filter="none" name="none" @if($v->none == 1) checked="checked" @endif  lay-skin="switch"   lay-text="是|否">
            
            </td>
            <td>{{$v->account}}</td>
            <td class="td-manage">
                <div class="layui-btn-group">
              <a title="查看" class="layui-btn layui-btn-xs layui-btn-primary" onclick="x_admin_show('查看','{{url($d['mcm']['controller'].'_show_'.$v->id)}}')" href="javascript:;">
                <i class="icon iconfont">&#xe6e6;</i>
              </a>
              <a title="编辑" class="layui-btn layui-btn-xs layui-btn-primary" onclick="x_admin_show('编辑','{{URL::signedRoute($d['mcm']['controller'].'.edit',['id'=>$v->id])}}')" href="javascript:;">
                <i class="icon iconfont">&#xe69e;</i>
              </a>
              <a title="删除" class="layui-btn layui-btn-xs layui-btn-primary" onclick="member_del(this,'要删除的id')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
              </div>
            </td>
          </tr>
            @foreach(json_decode($v->content) as $kkk => $vvv)
           <tr cate-id='{{$kkk}}_{{$v->id}}' fid='{{$v->id}}' >

            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;
              ├{{$vvv->k}}
            </td>
            <td>{{$vvv->v}}</td>
            <td>--/--</td>
               <td>{{isset($vvv->api)?'Api':'--'}}/{{isset($vvv->id)?'ID':'--'}}/{{isset($vvv->hash)?'URLhash':'--'}}/{{$vvv->req}}</td>
             <td>--/--</td>
             <td>--/--</td>
		
      <td>{{isset($vvv->s)?'是':'否'}}</td>
			<td>--/--</td>
            <td class="td-manage">
                <div class="layui-btn-group">
              <a title="删除" class="layui-btn layui-btn-xs layui-btn-primary" onclick="member_del(this,'要删除的id')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
              </div>
            </td>
          </tr>
          @endforeach
     
          
          @foreach(getYield($b['r']) as $vv)
          	@if($vv->type == 2 && $vv->fid == $v->id)
			<tr cate-id='{{$vv->id}}' fid='{{$v->id}}' >

            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <i class="layui-icon x-show" status='true'>&#xe623;</i>
              {{$vv->name}}
            </td>
             <td>{{$vv->e_name}}</td>
             	<td><input type="text" maxlength="4" data-id="{{$vv->id}}" value="{{$vv->weight}}" placeholder="权重" lay-filter="order_by" class="layui-input order_by">
            </td>
               <td>{{$type[$vv->type]}}</td>
              <td><i class="layui-icon {{$vv->icon}}"></i></td>
             <td>
           
              <input type="checkbox" data-id="{{$vv->id}}" lay-filter="state" name="state" @if($vv->state == 1) checked="checked" @endif  lay-skin="switch"   lay-text="正常|停用">
              
            </td>
              <td> <input type="checkbox" data-id="{{$vv->id}}" lay-filter="none" name="none" @if($vv->none == 1) checked="checked" @endif  lay-skin="switch"   lay-text="是|否">
           </td>
            <td>{{$vv->account}}</td>
            <td class="td-manage">
                 <div class="layui-btn-group">
              <a title="查看" class="layui-btn layui-btn-xs layui-btn-primary" onclick="x_admin_show('查看','{{url($d['mcm']['controller'].'_show_'.$vv->id)}}')" href="javascript:;">
                <i class="icon iconfont">&#xe6e6;</i>
              </a>
              <a title="编辑" class="layui-btn layui-btn-xs layui-btn-primary" onclick="x_admin_show('编辑','{{URL::signedRoute($d['mcm']['controller'].'.edit',['id'=>$vv->id])}}')" href="javascript:;">
                <i class="icon iconfont">&#xe69e;</i>
              </a>
              <a title="删除" class="layui-btn layui-btn-xs layui-btn-primary" onclick="member_del(this,'要删除的id')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
              </div>
            </td>
          </tr>
          
          @foreach(json_decode($vv->content) as $kkk => $vvv)
                 <tr cate-id='{{$kkk}}_{{$vv->id}}' fid='{{$vv->id}}' >

            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               ├{{$vvv->k}}
            </td>
             <td>{{$vvv->v}}</td>
             <td>--/--</td>
                <td>{{isset($vvv->api)?'Api':'--'}}/{{isset($vvv->id)?'ID':'--'}}/{{isset($vvv->hash)?'URLhash':'--'}}/{{$vvv->req}}</td>
             <td>--/--</td>
             
             <td>--/--</td>
             <td>{{isset($vvv->s)?'是':'否'}}</td>
			<td>--/--</td>
            <td class="td-manage">
               <div class="layui-btn-group">
              <a title="删除" class="layui-btn layui-btn-xs layui-btn-primary" onclick="member_del(this,'要删除的id')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
              </div>
            </td>
          </tr>
          @endforeach
          @endif
          @endforeach
          
          @elseif($v->type == 2 && $v->fid == 0)
             <tr cate-id='{{$v->id}}' fid='0' >

            <td>
              <i class="layui-icon x-show" status='true'>&#xe623;</i>{{$v->name}}
            </td>
            <td>{{$v->e_name}}</td>
            	<td><input type="text" maxlength="4" data-id="{{$v->id}}" value="{{$v->weight}}" placeholder="权重" lay-filter="order_by" class="layui-input order_by">
            </td>
              <td>{{$type[$v->type]}}</td>
             <td><i class="layui-icon {{$v->icon}}"></i></td>
             <td>
              <input type="checkbox" data-id="{{$v->id}}" lay-filter="state" name="state" @if($v->state == 1) checked="checked" @endif  lay-skin="switch"   lay-text="正常|停用">
          
            </td>
        <td> <input type="checkbox" data-id="{{$v->id}}" lay-filter="none" name="none" @if($v->none == 1) checked="checked" @endif  lay-skin="switch"   lay-text="是|否">
           </td>
            <td>{{$v->account}}</td>
            <td class="td-manage">
              <div class="layui-btn-group">
              <a title="查看" class="layui-btn layui-btn-xs layui-btn-primary" onclick="x_admin_show('查看','{{url($d['mcm']['controller'].'_show_'.$v->id)}}')" href="javascript:;">
                <i class="icon iconfont">&#xe6e6;</i>
              </a>
              <a title="编辑" class="layui-btn layui-btn-xs layui-btn-primary" onclick="x_admin_show('编辑','{{URL::signedRoute($d['mcm']['controller'].'.edit',['id'=>$v->id])}}')" href="javascript:;">
                <i class="icon iconfont">&#xe69e;</i>
              </a>
              <a title="删除" class="layui-btn layui-btn-xs layui-btn-primary" onclick="member_del(this,'要删除的id')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
              </div>
            </td>
          </tr>
       
             @foreach(json_decode($v->content) as $kkk => $vvv)
           <tr cate-id='{{$kkk}}_{{$v->id}}' fid='{{$v->id}}' >

            <td>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              ├{{$vvv->k}}
            </td>
            <td>{{$vvv->v}}</td>
            <td>--/--</td>
             <td>{{isset($vvv->api)?'Api':'--'}}/{{isset($vvv->id)?'ID':'--'}}/{{isset($vvv->hash)?'URLhash':'--'}}/{{$vvv->req}}</td>
             <td>--/--</td>
             <td>--/--</td>
		
      <td>{{isset($vvv->s)?'是':'否'}}</td>
			<td>--/--</td>
            <td class="td-manage">
                <div class="layui-btn-group">
              <a title="删除" class="layui-btn layui-btn-xs layui-btn-primary" onclick="member_del(this,'要删除的id')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
              </div>
            </td>
          </tr>
          @endforeach
     
          @endif
          @endforeach

        </tbody>
      </table>
      <table class="layui-table">
        <thead>
          <tr>   
            <th >方法名称</th>
            <th >E-name</th>
            <th style="width:80px;">权重</th>
            <th >状态</th>
            <th >是否显示</th>
            <th >API</th>
            <th >请求类型</th>
            <th>描述</th>
            <th  width="80">操作</th>
            </tr>
        </thead>
        <tbody>
        @foreach(getYield($b['r']) as $v)
        	@if($v->type == 3)
          <tr>
       
            <td>{{$v->name}}</td>
            <td>{{$v->e_name}}</td>
            <td >
            	<input type="text" maxlength="4" data-id="{{$v->id}}" value="{{$v->weight}}" placeholder="权重" lay-filter="order_by" class="layui-input order_by">
            </td>
            <td>{{$state[$v->state]}}</td>
            <td>{{$none[$v->none]}}</td>
            <td>{{$none[$v->api]}}</td>
            <td>{{$v->req_type}}</td>
            <td>{{$v->account}}</td>
            <td class="td-manage">
            <div class="layui-btn-group">
              <a title="查看" class="layui-btn layui-btn-xs layui-btn-primary" onclick="x_admin_show('查看','{{url($d['mcm']['controller'].'_show_'.$v->id)}}')" href="javascript:;">
                <i class="icon iconfont">&#xe6e6;</i>
              </a>
              <a title="编辑" class="layui-btn layui-btn-xs layui-btn-primary" onclick="x_admin_show('编辑','{{URL::signedRoute($d['mcm']['controller'].'.edit',['id'=>$v->id])}}')" href="javascript:;">
                <i class="icon iconfont">&#xe69e;</i>
              </a>
              <a title="删除" class="layui-btn layui-btn-xs layui-btn-primary" onclick="member_del(this,'要删除的id')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
              </div>
            </td>
          </tr>
          @endif
          @endforeach
        </tbody>
      </table>

 <!--endtable-->
 <!--page-->
       <div class="page">
      
       
     
      </div>
 <!---->
</div>
</div>
<div style="height: 100px; width: 100vw;"></div>

<div id="clickicon">
	<i id="top_click" class="layui-icon layui-icon-top"></i>   
</div>
@endsection
@section('js')
<script>
        layui.use(['form','layer'], function(){
        
          $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer,$req = false;

function recover(e,arr){
	e.attr('checked',!e.attr('checked'));
	var n = e.next();
	var em = n.children(':first');
	if(e.attr('checked')){
		n.addClass('layui-form-onswitch');	
		em.text(arr[0]);
	}else{
		n.removeClass('layui-form-onswitch');
		em.text(arr[1])
	}
	
}	
     	
//状态	
form.on('switch(state)', function(data){
	if($req)return false;
	$req = true;
	layer.load();

 var $this = $(this),id = $this.attr('data-id'); 
 $this.attr('checked' ,!$this.attr('checked'));
 var $arr =['正常','停用'],value = $this.attr('checked')?1:0;
 $.post("adminapi/{{$d['mcm']['controller']}}/state_"+id,{value:value,_method:'PUT'},function(e){		
 		 layer.msg(e.error == 0?'修改成功!':'修改失败!');	
 	    $req = false; 	
 	    layer.closeAll('loading');	
 	      if(!e.error == 0){
 	    	recover($this,$arr);
 	    }
 });

});  
//显示	
form.on('switch(none)', function(data){
	if($req)return false;
	$req = true;
	layer.load();
var $this = $(this),id = $this.attr('data-id'); 
$this.attr('checked' ,!$this.attr('checked'));
var $arr = ['是','否'],value =$this.attr('checked')?1:0;
 $.post("adminapi/{{$d['mcm']['controller']}}/none_"+id,{value:value,_method:'PUT'},function(e){		
 		 layer.msg(e.error == 0?'修改成功!':'修改失败!');	
 	   $req = false; 	
 	   layer.closeAll('loading');
 	     if(!e.error == 0){
 	    	recover($this,$arr);
 	    }
 });

}); 
//排序
      $('.order_by').change(function(){
      	if($req)return false;
      	$req = true;
      	layer.load();
      	var $this = $(this),id = $this.attr('data-id'),value = $this.val();
      	if(!/^[0-9]*$/.test(value)){
      		value = 0;
      		$this.val(0);
      	}
      
		 $.post("adminapi/{{$d['mcm']['controller']}}/weight_"+id,{value:value,_method:'PUT'},function(e){		
 		 layer.msg(e.error == 0?'修改成功!':'修改失败!');	
 		 $req = false; 	
 		 layer.closeAll('loading');		
 		});
		
      });	
      	
		
			
        });
          //删除
        function member_del(){
        layer.open({
        type: 'auto'
        ,offset:'auto'
        ,id: 'message' 
        ,content: '<div style="padding: 20px 100px;"><img src="./a/lib/layui/images/face/5.gif"/>看看就行,你想干啥?</div>'
        ,btn: '关闭'
        ,btnAlign: 'c' //按钮居中
        ,shade: 0 //不显示遮罩
     
      });
    
       }
     
   </script>
@endsection