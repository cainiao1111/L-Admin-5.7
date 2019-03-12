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
<p id="datacount" class="layui-btn x-right ">当前文件夹,共有图片<span class="layui-badge layui-bg-cyan" id="count_images">{{count($b['images'])}}</span> 张 </p>
  </div>
 </form>      
</div>


<hr class="layui-bg-gray">
</xblock>
 <div style="height: 10vh; width: 1vw;"></div>
 <div id="item_images" class="clearfix">
 @foreach(getYield($b['images']) as $v)
 <div class="image_div"><img class="image imageclick " data-url="{{$v}}" lay-src="storage/{{$v}}"/>
 	<hr /><p class="layui-btn layui-btn-xs  layui-btn-danger btn-delete">删除</p><p class="layui-btn layui-btn-xs layui-btn-normal btn-copy">复制</p>
 </div>
@endforeach
<div class="image_div" id="test1">
<button type="button" class="layui-btn layui-btn-primary image layui-icon layui-icon-add-1"  ></button>
<!--<hr /><p class="layui-btn layui-btn-xs  layui-btn-danger btn-delete">删除</p><p class="layui-btn layui-btn-xs layui-btn-normal btn-copy">复制</p>-->
</div>

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
  form=layui.form,fields={!!$b['files']!!},$req = false;
$('#fiels').files('{{$b['search']['a']}}','{{$b['search']['b']}}',fields,form),flow=layui.flow;
flow.lazyimg(); 
  //普通图片上传
  var uploadInst = upload.render({
    elem: '#test1'
    ,url: '{{URL::signedRoute('superupload',['a'=>$b['search']['a'],'b'=>$b['search']['b']])}}' ,
    before:function(){
    	layer.load();
    }
    ,done: function(res){
 	
       layer.closeAll('loading');	    
      if(res.error > 0){
        return layer.msg('上传失败!');
      }
      $('#test1').before('<div class="image_div"><img class="image imageclick" data-url="'+res.images+'" src="./storage/'+res.images+'"  lay-src="./storage/'+res.images+'"/><hr /><p class="layui-btn layui-btn-xs  layui-btn-danger btn-delete">删除</p><p class="layui-btn layui-btn-xs layui-btn-normal btn-copy">复制</p></div>');
       $('#count_images').text(parseInt($('#count_images').text())+1);
       return layer.msg('上传成功!');
    }
    ,error: function(){
      layer.closeAll('loading');	
   	  layer.msg('上传失败!');
   	  
    },accept:'image',multiple:true,acceptMime: 'image/*',size:{{$b['size']}}
  });
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
  $('#item_images').on('click','.btn-copy',function(){
  	var $this = $(this).prev().prev().prev();
	layer.msg('复制成功!');
	copyText($this.attr('lay-src'));
  });
   $('#item_images').on('click','.btn-delete',function(){
   	if($req)return false;
  	var $this = $(this).prev().prev();
  	layer.confirm('确认要删除吗？',function(index){
$req = true;
layer.load();
 $.post('{{URL::signedRoute('superdelete')}}',{_method:'DELETE',value:$this.attr('data-url')},function(e){	
 		layer.msg(e.error == 0?'删除成功!':'删除失败!');	
 	    $req = false; 	
 	    layer.closeAll('loading');	
 	    if(e.error == 0){
 	    
 	    $this.parent().remove();
 	     $('#count_images').text(parseInt($('#count_images').text())-1);
 	    }
   }); });
  	
  });
  
  function copyText(obj) {
  if (!obj) {
    return false;
  }
  var text;
  if (typeof(obj) == 'object') {
    if (obj.nodeType) { // DOM node
      obj = $(obj); // to jQuery object
    }
    try {
      text = obj.text();
      if (!text) { // Maybe <textarea />
        text = obj.val();
      }
    } catch (err) { // as JSON
      text = JSON.stringify(obj);
    }
  } else {
    text = obj;
  }
  //var $temp = $('<input>'); // Line feed is not supported
  var $temp = $('<textarea>');
  $('body').append($temp);
  $temp.val(text).select();
  var res = document.execCommand('copy');
  $temp.remove();
  return res;
}
});
  </script>
@endsection