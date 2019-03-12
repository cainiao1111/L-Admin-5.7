@extends('Admin.A.vessel')
@section('content')
<div class="layui-field-box">
<div class="layui-row">	
<xblock style="position: fixed; top: 0; left: 0; right: 0; z-index: 100;">
@if(PV($d,'create'))
<button class="layui-btn" onclick="x_admin_show('添加','{{url($d['mcm']['controller'].'_create')}}')"><i class="layui-icon">&#xe654;</i>添加</button>
@endif
<button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
@if(PV($d,'deletedatas'))
<button class="layui-btn layui-btn-danger" id="deleteDatas"><i class="layui-icon"></i>批量删除</button>
@endif
<button id="datacount" class="layui-btn x-right ">共有数据<span class="layui-badge layui-bg-cyan">{{$b['row']->total()}}</span> 条 </button>
<hr />
</xblock> 
<div style="height: 10vh; width: 1vw;"></div>
<!---->

<!--table-->

      <table class="layui-table layui-form">
        <thead>
          <tr>
        	<th style="width: 8px;"> <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div></th>
            <th >ID</th>
    		<th>名称</th>
  			<th  style="width: 100px;">排序</th>
    		<th>状态</th>
          <th>操作</th>
        </thead>
        <tbody>
        	@foreach(getYield($b['row']) as $v)
          <tr class="dom_item_{{$v->id}}">
          	<td>
          		<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->id}}'><i class="layui-icon">&#xe605;</i></div>		
          	</td>
            <td>{{$v->id}}</td>
            <td>{{$v->name}}</td>
            <td class="btn-order"><input type="text" maxlength="4" data-id="{{$v->id}}" value="{{$v->order_by}}" placeholder="排序" lay-filter="order_by" class="layui-input order_by"></td>
            <td class="btn-state">
              <input type="checkbox"   data-id="{{$v->id}}" lay-filter="state" name="state" @if($v->state == 1) checked="checked" @endif  lay-skin="switch"   lay-text="正常|停用">
            	
            </td>
            
            <td>
            	<div class="layui-btn-group">
            	<a title="查看" class="layui-btn layui-btn-xs layui-btn-primary bt-show" onclick="x_admin_show('查看','{{url($d['mcm']['controller'].'_show_'.$v->id)}}')" href="javascript:;">
                <i class="icon iconfont">&#xe6e6;</i>
              </a>
              <a title="编辑" class="layui-btn layui-btn-xs layui-btn-primary bt-edit" onclick="x_admin_show('编辑','{{URL::signedRoute($d['mcm']['controller'].'.edit',['id'=>$v->id])}}')" href="javascript:;">
                <i class="icon iconfont">&#xe69e;</i>
              </a>
              <a title="删除" class="layui-btn layui-btn-xs layui-btn-primary bt-delete" data-item="{{$v->id}}" data-h="{{URL::signedRoute($d['mcm']['controller'].'.destroy',['id'=>$v->id])}}" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            	</div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
 <!--endtable-->
 <!--page-->
       <div class="page">
   
       {{$b['row']->links()}}
     
      </div>
 <!---->
</div>
</div>

 <div style="height: 100px; width: 100vw;"></div>
@php
$sarr =
[
	'id'=>'id',
	'name'=>'名称',
	'order_by'=>'排序',
	'state'=>'状态'
];

@endphp
<div id="clickicon">
	<i id="search_show" class="layui-icon layui-icon-search"></i>
	<br />
	<i id="top_click" class="layui-icon layui-icon-top"></i>   
</div>
<div id="search" class="layui-anim layui-anim-upbit ">
    <form class="layui-form   layui-form-pane">
	<div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>条数</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="pag" placeholder="10-9999" value="{{$b['search']['pag']}}" pattern="^[1-9]{1}[0-9]+$"  maxlength="3"  autocomplete="off" lay-verify="required|number" placeholder="" class="layui-input">
    </div>
  </div>	
	
<div class="layui-form-item" pane="">
    <label class="layui-form-label"><span class="x-red">*</span>排序方式</label>
    <div class="layui-input-block" >
	 <input type="radio" name="order_value"  value="ASC" title="正序" @if($b['search']['order_value']== 'ASC') checked="" @endif>
     <input type="radio" name="order_value" value="DESC" title="倒序" @if($b['search']['order_value']== 'DESC') checked="" @endif>
	
    </div>
 </div>			
 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>排序字段</label>
    <div class="layui-input-block">
	<select name="order_name" lay-verify="required" lay-search="">
			@foreach($sarr as $k => $v)
          <option value="{{$k}}"   @if($b['search']['order_name']== $k)  selected="" @endif >{{$v}}</option>
			@endforeach
       </select>
    </div>
  </div>	
  
   <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>搜索字段</label>
    <div class="layui-input-block">
    	<select name="search_name" lay-verify="required" lay-search="">
			@foreach($sarr as $k => $v)
          <option value="{{$k}}" @if($b['search']['search_name']== $k)  selected="" @endif  >{{$v}}</option>
			@endforeach
      </select>
    </div>
  </div>	
  
    <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>搜索内容</label>
    <div class="layui-input-block">
      <input type="text"  name="search_value" value="{{$b['search']['search_value']}}"  autocomplete="off" placeholder= "搜索内容" placeholder="" class="layui-input">
    </div>
  </div>	
    <div class="layui-form-item">
      <button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon"></i></button>
      <p id="search_close" class=" layui-btn layui-btn-warm"><i class="layui-icon layui-icon-close"></i></p>
  </div>

      </form>
</div>


@endsection
@section('js')
<script>
layui.use(['form','layer'], function(){
          $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer
          ,$req = false;		
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
@if(PV($d,'state'))
		    //状态	
form.on('switch(state)', function(data){
	if($req)return false;
	$req = true;
	layer.load();

 var $this = $(this),id = $this.attr('data-id'); 
 $this.attr('checked',!$this.attr('checked'));
 var $arr = ['正常','停用'],value = $this.attr('checked')?1:0;
 $.post("adminapi/{{$d['mcm']['controller']}}/state_"+id,{value:value,_method:'PUT'},function(e){		
 		 layer.msg(e.error == 0?'修改成功!':'修改失败!');	
 	    $req = false; 	
 	    layer.closeAll('loading');	
 	    if(!e.error == 0){
 	    	recover($this,$arr);
 	    }
 });

});
@else
// disabled="disabled"
var btsfc = $('.btn-state').children(); 
btsfc.attr('disabled','disabled').addClass('layui-checkbox-disbaled layui-disabled'); 
@endif
@if(!PV($d,'show'))
$('.bt-show').remove(); 
@endif
@if(!PV($d,'edit'))
$('.bt-edit').remove(); 
@endif
@if(!PV($d,'destroy'))
$('.bt-delete').remove(); 
@else
//删除		
$('.bt-delete').click(function(){
var $this = $(this);
if($req)return false;
layer.confirm('确认要删除吗？',function(index){
$req = true;
layer.load();
 $.post($this.attr('data-h'),{_method:'DELETE'},function(e){		
 		 layer.msg(e.error == 0?'删除成功!':'删除失败!');	
 	    $req = false; 	
 	    layer.closeAll('loading');	
 	    if(e.error == 0){
 	    $('.dom_item_'+$this.attr('data-item')).remove();
 	    }
   }); });});
 @endif  
 
//排序
@if(PV($d,'orderby'))
      $('.order_by').change(function(){
      	if($req)return false;
      	$req = true;
      	layer.load();
      	var $this = $(this),id = $this.attr('data-id'),value = $this.val();
      	if(!/^[0-9]*$/.test(value)){
      		value = 0;
      		$this.val(0);
      	}
      
$.post("adminapi/{{$d['mcm']['controller']}}/orderby_"+id,{value:value,_method:'PUT'},function(e){		
 		 layer.msg(e.error == 0?'修改成功!':'修改失败!');	
 		 $req = false; 	
 		 layer.closeAll('loading');		
 		});
		
      });	 
 		

 @else
var btsfc = $('.btn-order').children(); 
btsfc.attr('disabled','disabled').addClass('layui-checkbox-disbaled layui-disabled'); 
 @endif
 
 //批量删除
 @if(PV($d,'deletedatas'))
 $('#deleteDatas').click(function(){
  var data = tableCheck.getData();
  if(data.length  == 0 ){
  	 layer.msg('请先选择数据!');
  	return false;
  }
 if($req)return false;
 layer.confirm('确认要删除吗',function(index){
 	 $req = true;
   layer.load();
 	 $.post("{{URL::signedRoute($d['mcm']['controller'].'.deletedatas')}}",{value:data,_method:'PUT'},function(e){		
 		 layer.msg(e.error == 0?'删除成功!':'删除失败!');	
 	    $req = false; 	
 	    layer.closeAll('loading');	
 	    if(e.error == 0){
   		$(".layui-form-checked").not('.header').parents('tr').remove();
 	    }
 });	

  });
 @endif
 });

 
   });    
   </script>
@endsection