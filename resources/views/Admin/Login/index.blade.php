@extends('Admin.A.vessel')
@section('content')

<style type="text/css">
	#login-bg{
		width: 100vw;
		height: 100vh;
	}
</style>
<div id="login-bg" class="login-bg">
    <div class="login layui-anim layui-anim-up">
        <div class="message">{{$b->admin_login_name}}</div>
        <div id="darkbannerwrap"></div>
        <form method="post" class="layui-form"  action="{{URL::signedRoute('login')}}">
        	@csrf
            <input name="a" placeholder="用户名"  required="required" type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="b" lay-verify="required" required="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input type="text" required="required" id='authcode'  maxlength="4"  autocomplete="off" lay-verify="required|authcode" placeholder="" class="layui-input">
             <hr class="hr15">
            <noscript>
            </form><form>
            </noscript>
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>
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
					 	}
          });

        });
   </script>
 
@endsection