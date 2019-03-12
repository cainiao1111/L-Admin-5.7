@extends('Admin.A.vessel')
@section('content')
  <div class="layui-field-box">

<form class="layui-form layui-form-pane" method="post">
@csrf
<input type="hidden" name="_method" value="PUT"/>
  <div class="layui-form-item">
    <label class="layui-form-label">登录账户</label>
    <div class="layui-input-block">
      <input type="text" required="required" disabled="disabled" value="{{$d['r']->account}}" class="layui-input">
    </div>
  </div>
 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>真实姓名</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="username" value="{{$d['r']->username}}" maxlength="10"  autocomplete="off" lay-verify="required|a" placeholder="请输入真实姓名" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>昵称</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="nickname" value="{{$d['r']->nickname}}" maxlength="10"  autocomplete="off" lay-verify="required|b" placeholder="请输入昵称" class="layui-input">
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
    <button class="layui-btn"  lay-submit="" lay-filter="demo2">修改</button>
    <input type="reset" class="layui-btn layui-btn-primary" value="重置" />
   <button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
   
  </div>
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
					 a: function(value){
					 	if($('[name=username]').val().length>10){
					 		 return '真实姓名不能大于10个字符!';
					 	}},
					 	b: function(value){
					 	if($('[name=nickname]').val().length>10){
					 		 return '昵称不能大于10个字符!';
					 	}},
					 	authcode:function(value){
					 		if($authcode != value){
					 			return '验证码不正确!';
					 		}
					 	}
          });
        });
    </script>
@endsection