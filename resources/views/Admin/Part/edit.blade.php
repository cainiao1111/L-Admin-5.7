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
    <label class="layui-form-label"><span class="x-red">*</span>名称</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="name" value="{{$b['r']->name}}"  maxlength="20"  autocomplete="off" lay-verify="required" placeholder="请输入名称" class="layui-input">
    </div>
  </div>

  	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>描述</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="account" value="{{$b['r']->account}}" lay-verify="required" maxlength="50"  autocomplete="off" placeholder="请输入描述" class="layui-input">
    </div>
  </div>
		
	<div class="layui-form-item layui-form-text">
	 <div class="layui-collapse">
  <div class="layui-colla-item">
    <h2 class="layui-colla-title"><span class="x-red">*</span>权限选择</h2>
    <div class="layui-colla-content layui-show">
 	<div id="permission_list" lay-filter="data1"></div>
    </div>
  </div>

</div>
		
   </div>
	
<input type="hidden" name="convenient_access" id="convenient_access" value="" />
 <div class="layui-form-item" pane="">
    <label class="layui-form-label"><span class="x-red">*</span>状态</label>
    <div class="layui-input-block">
	<input type="checkbox" @if($b['r']->state == 1) checked="checked" @endif name="state" value="1" lay-skin="switch"  lay-text="正常|停用">

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
	layui.config({
            base: "a/lib/layui/lay/modules/"
        }).use(['form','layer','eleTree'], function(){
          $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer,
          eleTree = layui.eleTree;
           var $authcode = randomNum(1000,9999);
       		$('#authcode').attr('placeholder','请输入验证码: '+$authcode);
					 form.verify({
					 	authcode:function(value){
					 		if($authcode != value){
					 			return '验证码不正确!';
					 		}
					 	}
          });
			//权限	
		
		eleTree.render({
		elem: "#permission_list",
		showCheckbox:true,
	   renderAfterExpand: false, 
		 data: {!!$b['row']!!},    
		emptText: "暂无权限"
		});
				
eleTree.on("nodeChecked(data1)",function(d) {
    var num = $('.eleTree-checkbox-checked');
    var numArr = new Array();
	num.parent().parent().each(function(){
		if($(this).attr('data-id') != 1 ){
			numArr.push($(this).attr('data-id'));
		}
	});
	$('#convenient_access').val(numArr);
})

   var num = $('.eleTree-checkbox-checked');
    var numArr = new Array();
	num.parent().parent().each(function(){
		if($(this).attr('data-id') != 1 ){
			numArr.push($(this).attr('data-id'));
		}
	});
	$('#convenient_access').val(numArr);
	});
    </script>
@endsection
<!--eleTree-checkbox-checked-->