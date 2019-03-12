@extends('Admin.A.vessel')
@section('content')
<link rel="stylesheet" href="./a/css/photoviewer.css">

<style type="text/css">
	.image{
		width: 100px;
		height: 100px;
		cursor:crosshair ;
	}
	.image_div{
		border: 1px solid #dddddd;
		padding: 10px;
		/*display: inline-block;*/
		margin: 4px;
		float: left;
	}
	#test1{
		font-size: 10px;
	}
	.btn-employ{
		margin-left: -100px;
		margin-top: -70px;
	}
	.btn-employ-all{
		/*border: 1px solid red;
		display: inline-block;
		margin-left: -100px;
		margin-top: -200px;*/
		margin-top: -18px;
	}
.clearfix {*zoom: 1;}
.clearfix:before,.clearfix:after {display: table;line-height: 0;content: "";}
.clearfix:after {clear: both;}
</style>

<div class="layui-field-box">

<xblock style="position: fixed; top: 0; left: 0; right: 0; z-index: 100;">
	<div class="layui-row">	
<form class="layui-form layui-form-pane ">
<div class="layui-form-item" id="fiels">
    <label class="layui-form-label">当前位置</label>
               <div class="layui-input-inline">
              <select name="a" lay-filter="a">
                <option value="">请选择</option>
              </select>
            </div>
            <div class="layui-input-inline">
              <select name="b" lay-filter="b">
                <option value="">请选择</option>
              </select>
            </div>

<button class="layui-btn" lay-submit="" lay-filter="sreach"><i class="layui-icon"></i></button>
<p class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></p>
 @if($b['t'] == 1)
 <p class="layui-btn layui-btn-normal add_imgs" >添加选中</p>
 @endif
<p id="datacount" class="layui-btn x-right ">当前文件夹,共有图片<span class="layui-badge layui-bg-cyan" id="count_images">{{count($b['images'])}}</span> 张 </p>

  </div>
 </form>      
</div>


<hr class="layui-bg-gray">
</xblock>
 <div style="height: 12vh; width: 1vw;"></div>
 <div id="item_images" class="clearfix layui-form">
 @foreach(getYield($b['images']) as $v)
 <div class="image_div"><img class="image imageclick " data-url="{{$v}}" lay-src="storage/{{$v}}"/>
 	@if($b['t'] == 0)
 	<p class="layui-btn layui-btn-xs layui-btn-normal btn-employ" data-url = "storage/{{$v}}">使用
 	@else
 	
 <div class="btn-employ-all">
      <input type="checkbox" lay-filter="employ"  value = "storage/{{$v}}" lay-skin="primary">
 </div> 
 		
 	@endif
 	</p>
 </div>
@endforeach

</div>

 <div style="height: 100px; width: 100vw;"></div>
<div id="clickicon">
	<i id="top_click" class="layui-icon layui-icon-top"></i>   
</div>
@endsection
@section('js')
<script type="text/javascript" src="./a/js/photoviewer.js"></script>
<script type="text/javascript" src="./a/js/files.js"></script>
<script>
layui.use(['form','upload','flow'], function(){
  var $ = layui.jquery
  ,upload = layui.upload,
  form=layui.form,fields={!!$b['files']!!}; 
$('#fiels').files('{{$b['search']['a']}}','{{$b['search']['b']}}',fields,form),flow=layui.flow;
flow.lazyimg(); 

  $('#item_images').on('click','.imageclick',function(e){
  e.preventDefault();
  var $this =  $(this);
  var $thisall = $('.imageclick');
  var items = [];
   	items.push({
      src: './storage/'+$this.attr('data-url')
    });
  var $index = 0,$i = 0;
  $thisall.each(function(){
    	var $$this = $(this);
    	let src = $$this.attr('data-url');
    	$i++;
    	if($this.attr('data-url') == src){
    		$index = $i;
    	}
      	items.push({
            src: './storage/'+src
   		 });
    });
	var  options = {
      index: $index
   };
  new PhotoViewer(items, options);	
  });
  
  @if($b['t'] == 0)
 $('.btn-employ').click(function(){
 	var $this = $(this);
 	layer.confirm('确认要用这张图片吗？',function(index){
	var $p = parent.$('.{{$b['dom']}}');
	$p.attr('src',$this.attr('data-url')).attr('value',$this.attr('data-url'));
	var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
	});		
	 })
@else
var numArr = new Array();
form.on('checkbox(employ)', function(data){
	numArr = [];
	var num = $('.layui-form-checked');
	num.prev().each(function(){
		numArr.push($(this).val());	
	});
});    
$('.add_imgs').click(function(){
	if(numArr.length == 0){
		layer.msg('还没有选择任何图片!');
		return false;
	}
	if(numArr.length > 5){
		layer.msg('一次最多选择5张!');
		return false;
	}
	layer.confirm('确认要用这些图片吗？',function(index){
		var $html = '';	
		for (var $i=0;$i<numArr.length;$i++) {
			$html += '<img src="'+numArr[$i]+'" alt=""  class="view_image" />';
			$html += '<input type="hidden" name="image[]"  value="'+numArr[$i]+'" />';
		}
	var $p = parent.$('#{{$b['dom']}}');
	$p.append($html);
	var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
	});
});

@endif

  

});
  </script>
@endsection