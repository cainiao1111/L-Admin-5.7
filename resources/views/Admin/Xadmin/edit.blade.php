@extends('Admin.A.vessel')
@section('content')
 <link rel="stylesheet" href="a/lib/layui/css/eleTree.css" media="all">
<style type="text/css">
	.none{
		display: none;
	}
</style>
<div class="layui-field-box">
<form class="layui-form layui-form-pane" method="post">
@csrf
<input type="hidden" name="_method" value="PUT"/>
 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>账号</label>
    <div class="layui-input-block">
      <input type="text" required="required" disabled="disabled" value="{{ $b['r']->account}}"  maxlength="16"  autocomplete="off" lay-verify="required|account" placeholder="请输入账号" class="layui-input">
    </div>
  </div>


 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>姓名</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="username" value="{{ $b['r']->username}}" maxlength="10"  autocomplete="off" lay-verify="required" placeholder="请输入姓名" class="layui-input">
    </div>
  </div>
  

  	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>昵称</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="nickname" value="{{ $b['r']->nickname}}"  maxlength="10"  autocomplete="off" lay-verify="required" placeholder="请输入昵称" class="layui-input">
    </div>
  </div>
  
 @php
 $r_id = $b['r']->r_id;
 @endphp
<div class="layui-form-item"   >
    <label class="layui-form-label"><span class="x-red">*</span>角色</label>
    <div class="layui-input-block">
		<select name="r_id" lay-verify="required" lay-search="">
			@foreach(getYield($b['row']) as $v)
          <option value="{{$v->id}}"  @if($v->id == $r_id) selected="selected"  @endif  >{{$v->name}}</option>
			@endforeach
       </select>
    </div>
  </div>
  
 <div class="layui-form-item" pane="" >
    <label class="layui-form-label"><span class="x-red">*</span>是否显示</label>
    <div class="layui-input-block">
		<input type="checkbox" name="none" @if($b['r']->none ) checked="" @endif value="1" lay-skin="switch"  lay-text="是|否">
    </div>
  </div>
	

<div class="layui-form-item"  pane="" >
    <label class="layui-form-label"><span class="x-red">*</span>超级管理</label>
    <div class="layui-input-block">
		<input type="checkbox" name="super_model"  @if( $b['r']->super_model ) checked="" @endif  value="1" lay-skin="switch"  lay-text="是|否">
    </div>
  </div>


 <div class="layui-form-item"  pane="">
    <label class="layui-form-label"><span class="x-red">*</span>状态</label>
    <div class="layui-input-block">
		<input type="checkbox" name="state"  @if( $b['r']->state ) checked="" @endif value="1" lay-skin="switch"  lay-text="正常|停用">
    </div>
  </div>
	
  <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>验证码</label>
    <div class="layui-input-block">
      <input type="text" required="required" id='authcode'  maxlength="4"  autocomplete="off" lay-verify="required|authcode" placeholder="" class="layui-input">
    </div>
  </div>


<noscript>
 </form><form>
</noscript>
  
  <div class="layui-form-item">
    <button class="layui-btn"  lay-submit="" lay-filter="demo2">保存</button>
    <input type="reset" class="layui-btn layui-btn-primary" value="重置" />
   <button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
   
  </div>
</form>

</div>
@endsection
@section('js')
<script>
	layui.use(['form','layer','eleTree'], function(){
          $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;
           var $authcode = randomNum(1000,9999);
       		$('#authcode').attr('placeholder','请输入验证码: '+$authcode);
					 form.verify({
					 	authcode:function(value){
					 		if($authcode != value){
					 			return '验证码不正确!';
					 		}
					 	}
					 	
          });
	

	});
    </script>
@endsection
<!--eleTree-checkbox-checked-->