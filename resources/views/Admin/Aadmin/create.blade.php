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

 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>账号</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="account" value="{{ old('account') }}"  maxlength="16"  autocomplete="off" lay-verify="required|account" placeholder="请输入账号" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 管理员的账号</div>
  </div>


 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>姓名</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="username" value="{{ old('username') }}" maxlength="10"  autocomplete="off" lay-verify="required" placeholder="请输入姓名" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 管理员的姓名</div>
  </div>
  
   <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>密码</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="password" value="{{ old('password') }}"  maxlength="18"  autocomplete="off" lay-verify="required|pass" placeholder="请输入密码" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 管理员的密码</div>
  </div>
  
  	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>昵称</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="nickname" value="{{ old('nickname') }}"  maxlength="10"  autocomplete="off" lay-verify="required" placeholder="请输入昵称" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 管理员的昵称</div>
  </div>
  
 @php
 $r_id = old('r_id');
 @endphp
<div class="layui-form-item"   >
    <label class="layui-form-label"><span class="x-red">*</span>角色</label>
    <div class="layui-input-inline">
		<select name="r_id" lay-verify="required" lay-search="">
			@foreach(getYield($b['row']) as $v)
          <option value="{{$v->id}}"  @if($v->id == $r_id) selected="selected"  @endif  >{{$v->name}}</option>
			@endforeach
       </select>
    </div>
    <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 管理员的角色</div>
  </div>
  

	



 <div class="layui-form-item"  pane="">
    <label class="layui-form-label"><span class="x-red">*</span>状态</label>
    <div class="layui-input-block">
		<input type="checkbox" name="state"  @if( old('state') ) checked="" @endif value="1" lay-skin="switch"  lay-text="正常|停用">
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
  	
  @if(PV($d,'store'))
    <button class="layui-btn"  lay-submit="" lay-filter="demo2">保存</button>
    <input type="reset" class="layui-btn layui-btn-primary" value="重置" />
   <button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
   </div>
  @endif
</form>

</div>
@endsection
@section('js')
<script>
	layui.use(['form','layer'], function(){
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
					 	},
					 	account:function(){
					 		if($('[name=account]').val().length>10){
					 		 return '登录账户最大长度为16位!';
					 		}
					 		if($('[name=account]').val().length<4){
					 		 return '登录账户最小长度为4位!';
					 		}
					 		
					 	},
					 	pass:function(){
					 		if($('[name=password]').val().length<6){
					 		 return '密码最小长度为6位!';
					 		}
					 	}
          });
	

	});
    </script>
@endsection
<!--eleTree-checkbox-checked-->