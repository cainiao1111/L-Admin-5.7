@extends('Admin.A.vessel')
@section('content')
<style type="text/css">
	#artisan_content{
		background-color: #111;
		border: 4px solid #aaa;
		color: #bbb;
		font-weight: 900;
		padding: 1vh 1vw;
		height: 33vh;
		overflow-y:auto;
	}
	#list_list{
		height: 33vh;
		overflow-y:auto;
		padding: 1vh 1vw;
		border: 4px solid #aaa;
		margin: 1vh 0;
	}

</style>
<div class=" layui-field-box">
	 	<pre id="artisan_content">Hello World!
		</pre>
	 	
<div id="list_list">
 		<table class="layui-table" lay-size="sm">
  <thead>
    <tr>
      <th>命令</th>
      <th>描述</th>
    </tr> 
  </thead>
  <tbody>
    <tr>
      <td>key:generate</td>
      <td>生成Key</td>
    </tr> 
       <tr>
      <td>	cache:clear | config:clear </td>
      <td>清除</td>
       <tr>
      <td>down [ --message="返回信息"] [--retry=请求头] [--allow=可以访问的IP]</td>
      <td>开启维护</td>
    </tr> 
       <tr>
      <td>up</td>
      <td>关闭维护</td>
    </tr> 
        </tr> 
       <tr>
      <td>config:cache</td>
      <td>缓存配置文件</td>
    </tr> 
        </tr> 
       <tr>
      <td>route:cache</td>
      <td>路由缓存</td>
    </tr> 
        <tr>
      <td>route:clear</td>
      <td>清除路由缓存/td>
    </tr> 
        <tr>
      <td>make:middleware [名称]</td>
      <td>创建中间键 </td>
    </tr> 
        <tr>
      <td>make:controller [名称] </td>
      <td>创建控制器</td>
    </tr> 
    
        <tr>
      <td>make:request  [名称] </td>
      <td>创建验证|位置 : app\http\request\</td>
    </tr> 
         <tr>
      <td>make:model  [名称] </td>
      <td>创建构造器 | 位置 app\名称</td>
    </tr> 
        <tr>
      <td>make:controller [名称] --resource   </td>
      <td>创建资源控制器</td>
    </tr> 
    <tr >
    	<td colspan="2">...</td>
    </tr>
  </tbody>
</table>
 	</div>
      
<form class="layui-form layui-form-pane"  >
  <div class="layui-form-item">
    <label class="layui-form-label">artisan命令</label>
    <div class="layui-input-block">
      <input type="text" name="a" required="required" maxlength="30"  autocomplete="off" lay-verify="required" placeholder="route:cache" class="layui-input">
    </div>
  </div>

   <noscript>
  </form><form>
 </noscript>
  <div class="layui-form-item">
    <button class="layui-btn" lay-submit=""  lay-filter="exec">执行</button>
    <button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
   	<p class="layui-btn layui-btn-normal execs" data-id="0">route:cache</p>
  	<p class="layui-btn layui-btn-normal execs" data-id="1">route:clear</p>
  	<p class="layui-btn layui-btn-normal execs" data-id="2">config:cache</p>
  	<p class="layui-btn layui-btn-normal execs" data-id="3">config:clear</p>
  </div>
</form>
 	
      	
</div>

@endsection
@section('js')
<script>
	layui.use(['form','layer'], function(){
          $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer,
          $exec=false,$url="{{URL::signedRoute('superartisan')}}";

form.on('submit(exec)', function(data){
	if($exec) return false;
	$exec = true;
	layer.load();
  $.post($url,{_method:'PUT',type:1,value:data.field.a},function(e){
  	$('#artisan_content').html(e);
  	$exec = false;
  	layer.closeAll('loading');	
  });
  return false; 
});

$('.execs').click(function(){
	if($exec) return false;
	var $this = $(this);
	var data = {index:$this.attr('data-id'),_method:'PUT'};
	layer.load();
	  $.post($url,data,function(e){
  	$('#artisan_content').html(e);
  	$exec = false;
  	layer.closeAll('loading');	
  });
});

	});
    </script>
@endsection