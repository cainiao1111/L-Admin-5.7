@extends('Admin.A.vessel')
@section('content')
<style type="text/css">
	.modules{
		display: none;
	}
	.module_1{
		display: block;
	}
</style>
<div class="layui-field-box">
<form class="layui-form layui-form-pane" method="post">
@csrf
 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>名称</label>
    <div class="layui-input-block">
      <input type="text" required="required" name="name" value="{{old('name')}}" maxlength="20"  autocomplete="off" lay-verify="required" placeholder="请输入名称" class="layui-input">
    </div>
  </div>
  
   <div class="layui-form-item modules module_3">
    <label class="layui-form-label"><span class="x-red">*</span>请求类型</label>
    <div class="layui-input-block">
    	 <select name="req_type" lay-verify="required" lay-search="">
          <option value="get">get</option>
          <option value="post">post</option>
          <option value="put">put</option>
          <option value="delete">delete</option>
       </select>
    </div>
  </div>
  
   <div class="layui-form-item modules module_3" pane="">
    <label class="layui-form-label"><span class="x-red">*</span>API</label>
    <div class="layui-input-block">
    <input type="radio" name="api" value="1" title="是">
    <input type="radio" name="api" value="0" title="否" checked="">
    </div>
  </div>
  
  
	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>E-name</label>
    <div class="layui-input-block">
      <input type="text" required="required" value="{{old('e_name')}}" name="e_name" lay-verify="required" maxlength="20"  autocomplete="off" placeholder="请输入E-name" class="layui-input">
    </div>
  </div>
  
      <div class="layui-form-item modules module_1 module_2">
            <label for="" class="layui-form-label"><span class="x-red">*</span>选择图标</label>
            <div class="layui-input-block">
                <input type="text" id="iconPicker"  lay-filter="iconPicker" class="layui-input">
                <input type="hidden" id='icon' name="icon"  value="layui-icon-rate-half" />
            </div>
       </div>
  
  	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>描述</label>
    <div class="layui-input-block">
      <input type="text" required="required" value="{{old('account')}}" name="account" lay-verify="required" maxlength="50"  autocomplete="off" placeholder="请输入描述" class="layui-input">
    </div>
  </div>

 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>类别</label>
    <div class="layui-input-block" >
      <select name="type" lay-verify="required" lay-filter="type" lay-search="">
          <option value="1">权限组</option>
          <option value="2">控制器</option>
          <option value="3">方法</option>
        </select>

    </div>
  </div>
	

  
   <div class="layui-form-item modules module_2">
    <label class="layui-form-label"><span class="x-red">*</span>所属组</label>
    <div class="layui-input-block" >
      <select name="fid" lay-verify="required" lay-search="">
      	  <option value="0">顶级</option>
      	  @foreach(getYield($b['row']) as $v)
      
      	  @if($v->type == 1)
          	<option value="{{$v->id}}">{{$v->name}}</option>
          @endif
          @endforeach
          
       </select>
    </div>
  </div>

  
  <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>权重</label>
    <div class="layui-input-block">
      <input type="text" required="required"  value="{{old('weight')}}" name="weight" value="0"  maxlength="4"  autocomplete="off" lay-verify="required|weight" placeholder="请输入权重" class="layui-input">
    </div>
  </div>

  
  <div class="layui-form-item"  pane="">
    <label class="layui-form-label"><span class="x-red">*</span>是否显示</label>
    <div class="layui-input-block">
	 <input type="radio" name="none" value="1" title="是">
    <input type="radio" name="none" value="0" title="否" checked="">
    </div>
  </div>
  <div class="layui-form-item layui-form-text modules module_2 module_1">
  <label class="layui-form-label"><span class="x-red">*</span>拥有方法</label>
  <div class="layui-input-block">
  <table class="layui-table">
    <thead>
      <tr>
        <th>名称</th>
        <th>方法</th>
        <th>是否显示</th>
        <th>API</th>
        <th>参数</th>
        <th>URLhash</th>
        <th>请求类型</th>
        <th>操作</th>
      </tr> 
    </thead>
    <tbody id="table_item">
  
      @foreach(getYield($b['row']) as $k=> $v)
       @if($v->type == 3)
      <tr class="removed" id="table_id_{{$k}}">
        <td> 
        <input type="text" required="required" name="content[{{$k}}][k]" maxlength="20"  autocomplete="off" lay-verify="required" placeholder="请输入名称" value="{{$v->name}}" class="layui-input">
        </td>
        <td>
         <input type="text" required="required" name="content[{{$k}}][v]"  maxlength="20"  autocomplete="off" lay-verify="required" placeholder="请输入方法" value="{{$v->e_name}}" class="layui-input">
        </td>
        <td>
     <input type="checkbox"   name="content[{{$k}}][s]" @if($v->none == 1) checked="checked" @endif  lay-skin="switch"   lay-text="是|否">

        </td>
        <td>
     <input type="checkbox"   name="content[{{$k}}][api]" @if($v->api == 1) checked="checked" @endif  lay-skin="switch"   lay-text="是|否">      	
        </td>
        <td>
     <input type="checkbox"   name="content[{{$k}}][id]"   lay-skin="switch"   lay-text="是|否">
      	      	
        </td>
        <td>
       <input type="checkbox"   name="content[{{$k}}][hash]"   lay-skin="switch"   lay-text="是|否">  	
        	
        </td>
        <td>
        	
         <input type="text" required="required" name="content[{{$k}}][req]"  maxlength="10"  autocomplete="off" lay-verify="required" placeholder="请输入请求类型" value="{{$v->req_type}}" class="layui-input">
        	
        </td>
        <td >
          <p class="layui-btn layui-btn-sm layui-btn-danger deletep" data-id="{{$k}}"><i class="layui-icon"></i> </p>
        </td>
      </tr>
       @endif
      @endforeach
         <tr id="additemsx">
        <td colspan="3" id="additem">
         <p  class="layui-btn layui-btn-fluid layui-btn-warm">添加方法</p>
        </td>
        <td colspan="5">
        	
        <p class="layui-btn layui-btn-fluid  layui-btn-danger deletepall" >全部删除 </p>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
</div>

 <div class="layui-form-item " pane="" >
    <label class="layui-form-label"><span class="x-red">*</span>状态</label>
    <div class="layui-input-block">
			<input type="checkbox" name="state" value="1" lay-skin="switch"   lay-text="正常|停用">
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
   			 base: './a/lib/layui/lay/modules/'
		}).extend({
    	iconPicker: 'iconPicker'
		});
        layui.use(['form','layer','iconPicker'], function(){
          $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer,
          iconPicker = layui.iconPicker;
           var $authcode = randomNum(1000,9999);
       		$('#authcode').attr('placeholder','请输入验证码: '+$authcode);
					 form.verify({
					 	authcode:function(value){
					 		if($authcode != value){
					 			return '验证码不正确!';
					 		}
					 	},
					 	weight:function(value){
					 	
					 		if(!(value%1 === 0)){
					 			return '请输入0-9999的整数!';	
					 		}
					 		
					 	}
          });
		
form.on('select(type)', function(data){
	var $va = data.value;
  	$('.modules').css('display','none');
  	$('.module_'+$va).css('display','block');
});     



		
		       iconPicker.render({
                // 选择器，推荐使用input
                elem: '#iconPicker',
                // 数据类型：fontClass/unicode，推荐使用fontClass
                type: 'fontClass',
                // 是否开启搜索：true/false
                search: true,
                // 是否开启分页
                page: true,
                // 每页显示数量，默认12
                limit: 16,
                // 点击回调
                click: function (data) {
                    $('#icon').val(data.icon);
                }
       
            });

			 iconPicker.checkIcon('iconPicker', 'layui-icon-rate-half');
  
			$('#table_item').on('click','.clickdom',function(){
				var $this = $(this);
				var em = $this.children(':first');
				var $prev = $this.prev();
				if($this.hasClass('layui-form-onswitch')){
					$this.removeClass('layui-form-onswitch');
					em.text('否');
				}else{
					$this.addClass('layui-form-onswitch');
					em.text('是');
				}
				$prev.attr('checked',!$prev.attr('checked'));
			});
			
        	var $k = {{count($b['row'])+1}};
           $('#additem').click(function(){
              var $this = $('#additemsx');
              $html = '';
               $html +='<tr class="removed" id="table_id_'+$k+'">';
         $html +=' <td> ';
         $html +='<input type="text" required="required" name="content['+$k+'][k]" maxlength="20"  autocomplete="off" lay-verify="required" placeholder="请输入名称" class="layui-input">';
         $html +='</td>';
        $html +=' <td>';
         $html +=' <input type="text" required="required" name="content['+$k+'][v]"  maxlength="20"  autocomplete="off" lay-verify="required" placeholder="请输入方法" class="layui-input">';
        $html +=' </td>';
        
        $html +=' <td>';
       $html +='<input type="checkbox" name="content['+$k+'][s]" checked="checked" lay-skin="switch" lay-text="是|否">';
       $html +='<div class="layui-unselect layui-form-switch layui-form-onswitch clickdom" lay-skin="_switch"><em>是</em><i></i></div>';

        $html +=' </td>';
        
         $html +=' <td>';
       $html +='<input type="checkbox" name="content['+$k+'][api]" checked="checked" lay-skin="switch" lay-text="是|否">';
       $html +='<div class="layui-unselect layui-form-switch layui-form-onswitch clickdom" lay-skin="_switch"><em>是</em><i></i></div>';

        $html +=' </td>';
 
		 $html +=' <td>';
       $html +='<input type="checkbox" name="content['+$k+'][id]" checked="checked" lay-skin="switch" lay-text="是|否">';
       $html +='<div class="layui-unselect layui-form-switch layui-form-onswitch clickdom" lay-skin="_switch"><em>是</em><i></i></div>';

        $html +=' </td>';
			
		  $html +=' <td>';
       $html +='<input type="checkbox" name="content['+$k+'][hash]" checked="checked" lay-skin="switch" lay-text="是|否">';
       $html +='<div class="layui-unselect layui-form-switch layui-form-onswitch clickdom" lay-skin="_switch"><em>是</em><i></i></div>';

        $html +=' </td>';
			
		 $html +=' <td>';
         $html +=' <input type="text" required="required" name="content['+$k+'][req]"  maxlength="20" value="put"  autocomplete="off" lay-verify="required" placeholder="请输入请求类型" class="layui-input">';
        $html +=' </td>';

        $html +=' <td >';
         $html +='  <p class="layui-btn layui-btn-sm layui-btn-danger deletep" data-id="'+$k+'"><i class="layui-icon"></i> </p>';
       $html +='  </td>';
      $html +=' </tr>';

               $this.before( $html);
                ++$k;
           });
	//状态


      $('#table_item').on('click','.deletep',function(){
              $index = $(this).attr('data-id');
               $('#table_id_'+$index).remove();
           });

		$('.deletepall').click(function(){
			$('.removed').remove();
			$k = 0;
		});
        });
    </script>
@endsection