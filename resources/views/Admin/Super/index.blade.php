@extends('Admin.A.vessel')
@section('content')
<style type="text/css">
	#canvas{

		position: fixed;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		z-index: 10;
	}
	.login-bgx{
		position: fixed;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		z-index: 20;
	}
	.login{
		min-height: 0;
	}
</style>
<div class="login-bgx" >
    <div class="login layui-anim layui-anim-up">
        <form method="post" class="layui-form" >
        	@csrf
            <input name="b" required="required" lay-verify="required"  placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
      		<input type="text" required="required" id='authcode'  maxlength="4"  autocomplete="off" lay-verify="required|authcode" placeholder="" class="layui-input">
             <hr class="hr15">
             <noscript>
            </form><form>
 			</noscript>
            <input value="登录" lay-submit  style="width:50%;" type="submit">
            <input value="返回"   style="width:47%;" onclick="javaScript:window.location.href='{{url('admin')}}'" type="button">
            <hr class="hr20" >
            
        </form>
    </div>
</div>
<canvas id="canvas" > </canvas>
@endsection
@section('js')
<script type="text/javascript" src="./a/js/BK.js"></script>
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