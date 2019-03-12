@extends('Admin.A.vessel')
@section('content')
<div class="layui-field-box">
<form class="layui-form layui-form-pane" method="post">
	@csrf
<input type="hidden" name="_method" value="PUT"/>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
  <ul class="layui-tab-title">
    <li class="layui-this">网站设置</li>
    <li>IP设置</li>
    <li>管理员设置</li>
    <li>上传设置</li>
  </ul>
  <div class="layui-tab-content">
  	 <div class="layui-tab-item layui-show ">
  	 	
	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>登录页标题</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="admin_login_name"  value="{{$b['admin_login_name']}}" maxlength="30"  autocomplete="off" lay-verify="required" placeholder="请输入后台的名称" class="layui-input">
    </div>
     <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 后台登录页的标题</div>
  </div> 	
  	
	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>后台名称</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="admin_name"  value="{{$b['admin_name']}}" maxlength="30  autocomplete="off" lay-verify="required" placeholder="请输入后台的名称" class="layui-input">
 </div>
     <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 后台的名称</div>
  </div>
  
   <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>底部内容</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="admin_foot"  value="{{$b['admin_foot']}}"  autocomplete="off" lay-verify="required" placeholder="请输入后台底部内容" class="layui-input">
    </div>

  </div>
  	 </div>
  		<div class="layui-tab-item ">
  	<blockquote class="layui-elem-quote layui-quote-nm layui-icon layui-icon-tips x-red"> IP 验证只对普通管理员有效!</blockquote>
  	<div class="layui-form-item"  pane="">
    <label class="layui-form-label"><span class="x-red">*</span>IP验证</label>
    <div class="layui-input-block">
	 <input type="radio" name="ip[ip_index]" @if($b['ip']['ip_index']==0) checked="" @endif value="0" title="关闭" >
   <input type="radio" name="ip[ip_index]" @if($b['ip']['ip_index']==1) checked="" @endif value="1" title="白名单" >
   <input type="radio" name="ip[ip_index]" @if($b['ip']['ip_index']==2) checked="" @endif value="2" title="黑名单" >
    </div>
  </div>
  	
	 <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">IP白名单</label>
    <div class="layui-input-block">
     <textarea name="a" placeholder="请输入IP白名单,以-号分割" class="layui-textarea">{{implode('-',$b['ip'][1])}}</textarea>
    </div>
  </div>
  
  	 <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">IP黑名单</label>
    <div class="layui-input-block">
     <textarea name="b" placeholder="请输入IP黑名单,以-号分割" class="layui-textarea">{{implode('-',$b['ip'][2])}}</textarea>
    </div>
  </div>
  			
   	</div>
   	<!--管理员-->
  	 <div class="layui-tab-item ">
  		
  	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>密码</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="admin_pass"  value="{{$b['admin_pass']}}" maxlength="30"  autocomplete="off" lay-verify="required|p" placeholder="请输入默认密码" class="layui-input">
    </div>
     <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 重置密码管理员密码默认值</div>
  </div> 	
  		
  	  	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>超级密码</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="admin_s_pass"  value="{{$b['admin_s_pass']}}" maxlength="30"  autocomplete="off" lay-verify="required|p" placeholder="请输入默认密码" class="layui-input">
    </div>
     <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 重置密码超级管理员密码默认值</div>
  </div> 	
  		
  	</div>
  	<!--管理员-->
  	 <div class="layui-tab-item ">
  		
  	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>size</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="image_upload_size"  value="{{$b['image_upload_size']}}" maxlength="2"  autocomplete="off" lay-verify="required|number" placeholder="请输入默认密码" class="layui-input">
    </div>
     <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 设置文件最大可允许上传的大小,单位 KB,0为不限制</div>
  </div> 	
  		

  		
  	</div>
  	<!---->
  	
  		  <noscript>
  </form><form>
 </noscript>
       <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>验证码</label>
    <div class="layui-input-block">
      <input type="text" required="required" id='authcode'  maxlength="4"  autocomplete="off" lay-verify="required|authcode" placeholder="" class="layui-input">
    </div>
  </div>
  
 
  <div class="layui-form-item">
    <button class="layui-btn"  lay-submit="" lay-filter="demo2">保存</button>
  </div>
  </div>
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
			,
			authcode:function(value){
				if($authcode != value){
					 			return '验证码不正确!';
					}
				}
          });

        });
    </script>
@endsection