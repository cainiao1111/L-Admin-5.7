@extends('Admin.A.vessel')
@section('content')
<div class="layui-field-box">
<form class="layui-form layui-form-pane" method="post">
@csrf
<input type="hidden" name="_method" value="PUT"/>
  <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>旧密码</label>
    <div class="layui-input-block">
      <input type="password" name="a" required="required" maxlength="18"  autocomplete="off" lay-verify="required|p" placeholder="请输入旧密码" class="layui-input">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>新密码</label>
    <div class="layui-input-block">
      <input type="password" name="b" required="required" maxlength="18" autocomplete="off" lay-verify="required|p" placeholder="请输入新密码" class="layui-input">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>验证新密码</label>
    <div class="layui-input-block">
      <input type="password" name="c" required="required" maxlength="18" autocomplete="off" lay-verify="required|p|r" placeholder="请再输入新密码" class="layui-input">
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
           p: [/(.+){6,18}$/, '密码必须6到18位']
					 ,r: function(value){
                if($('[name=b]').val()!=$('[name=c]').val()){
                    return '两次密码不一致!';
                }
            },
					 	authcode:function(value){
					 		if($authcode != value){
					 			return '验证码不正确!';
					 		}
					 	}
          });

        });
    </script>
@endsection