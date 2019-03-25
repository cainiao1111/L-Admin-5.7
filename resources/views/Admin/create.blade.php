@extends('Admin.A.vessel')
@section('content')
<link rel="stylesheet" href="./a/css/photoviewer.css">
<div class="layui-field-box">
<form class="layui-form layui-form-pane" method="post">
@csrf


	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>商品名称</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="name" value="{{old('name')}}"  maxlength="20"  autocomplete="off" lay-verify="required" placeholder="请输入商品名称" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 商品的名称</div>
  </div>


	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>商品排序</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="order_by" value="0"  maxlength="4"  autocomplete="off" lay-verify="required|number" placeholder="请输入商品排序" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> 商品的排序,越大越在前</div>
  </div>
  
<div class="layui-form-item" id="item_images">
<div class="layui-upload">
  <button type="button" class="layui-btn" id="test1">上传图片</button>
  <p type="button" class="layui-btn  layui-icon layui-icon-picture-fine layui-btn-normal" onclick="x_admin_show('历史图片','{{url('picture.history.0.location')}}')" > 历史图片</p>
  <div class="layui-upload-list">
    <img src="{{old('img')}}" alt="" id="imageshow" class="view_image location" />
     <input type="hidden"  name="img" id="imagevalue" value="{{old('img')}}"  autocomplete="off" lay-verify="imagevalue"  class="layui-input location">
  
  </div>
</div>   
<!---->

<blockquote class="layui-elem-quote">商品轮播图 <button type="button" class="layui-btn" id="test2">上传图片</button>  <p type="button" class="layui-btn  layui-icon layui-icon-picture-fine layui-btn-normal" onclick="x_admin_show('历史图片','{{url('picture.history.1.location')}}')" > 历史图片</p></blockquote>
<div id="location"></div>

<!---->

</div>   



   <div class="layui-form-item layui-form-text">
    <label class="layui-form-label"><span class="x-red">*</span>简介</label>
    <div class="layui-input-block">   	
    	  <textarea placeholder="请输入简介" name="account" maxlength="255" lay-verify="required" class="layui-textarea">{{old('account')}}</textarea>  
    </div>
  </div>

 <div class="layui-form-item" >

	<div id='text'>{!!old('text')!!}</div>

  </div>

 <div class="layui-form-item" pane="">
    <label class="layui-form-label"><span class="x-red">*</span>状态</label>
    <div class="layui-input-block">
		<input type="checkbox" name="state" value="1" lay-skin="switch"  lay-text="正常|停用">
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

  @if(PV($d,'store'))
  <div class="layui-form-item">
    <button class="layui-btn"  lay-submit="" lay-filter="demo2">保存</button>
    <input type="reset" class="layui-btn layui-btn-primary" value="重置" />
   <button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
   @endif
  </div>
</form>

</div>
@endsection
@section('js')
<script src='a/tinymce/tinymce.min.js'></script>
<script type="text/javascript" src="./a/js/photoviewer.js"></script>
<script>
	var $url = '{{URL::signedRoute('imgupload',['a'=>mt_rand(0,999),'b'=>mt_rand(0,999)])}}';
	layui.use(['form','layer','upload'], function(){
          $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer,upload = layui.upload;
           var $authcode = randomNum(1000,9999);
       		$('#authcode').attr('placeholder','请输入验证码: '+$authcode);
					 form.verify({
					 	authcode:function(value){
					 		if($authcode != value){
					 			return '验证码不正确!';
					 		}
					 	},
					 	imagevalue:function(v){
					 		if(v.length == 0){
					 			return '请上传图片!';
					 		}
					 		
					 	}
          });
 //duotu
  $('#item_images').on('click','.view_image',function(e){
  e.preventDefault();
  var $this =  $(this);
  var $thisall = $('.view_image');
  var items = [];
   	items.push({
      src: $this.attr('src')
    });
  var $index = 0,$i = 0;
    $thisall.each(function(){
    	var $$this = $(this);
    	let src = $$this.attr('src');
    	$i++;
    	if($this.attr('src') == src){
    		$index = $i;
    	}
      	items.push({
            src: src
   		 });
    });
	var  options = {
      index: $index
   };
  new PhotoViewer(items, options);	
  });         
 
  	//图片预览
// $('#imageshow').click(function(e){
//e.preventDefault();
//var $this =  $(this);
//var items = [];
//items.push({ src: $this.attr('src')});
//var  options = {index: $this.index()};
//new PhotoViewer(items, options);	
//});

	//普通图片上传
  var uploadInst = upload.render({
    elem: '#test1'
    ,url: $url
    ,before: function(){
     layer.load();
    }
    ,done: function(res){
      layer.closeAll('loading');	
      if(res.code > 0){
        return layer.msg('上传失败!');
      }
      $('#imageshow').attr('src',res.location);
      $('#imagevalue').val(res.location);
      return layer.msg('上传成功!');
    }
    ,error: function(){
    	   layer.closeAll('loading');	
    	return layer.msg('上传失败!');
    },accept:'image',acceptMime: 'image/*',size:{{$b}}
  });

  //轮播图上传
  var uploadInst = upload.render({
    elem: '#test2'
    ,url: $url
    ,before: function(){
     layer.load();
    }
    ,done: function(res){
      layer.closeAll('loading');  
      if(res.code > 0){
        return layer.msg('上传失败!');
      }
      var $html = '<img src="'+res.location+'" alt=""  class="view_image" />';
      $html += '<input type="hidden" name="image[]"  value="'+res.location+'" />';
      $html += '<p class="layui-btn layui-btn-danger layui-btn-xs delete_images">删除</p>';
      $('#location').append($html);
      return layer.msg('上传成功!');
    }
    ,error: function(){
         layer.closeAll('loading'); 
      return layer.msg('上传失败!');
    },accept:'image',acceptMime: 'image/*',multiple:true,size:{{$b}}
  });

  $('#location').on('click','.delete_images',function(){

    var $this = $(this),
     $img = $this.prev('input').prev('img'), 
     $input = $this.prev('input'); 
     $this.remove();
     $img.remove();
     $input.remove();
  });

	});


  tinymce.init({
    selector: 'div#text',  
	language: 'zh_CN',
 	plugins: 'lists fullscreen image code codesample  advlist imagetools imageupload importcss link hr emoticons textcolor directionality  preview insertdatetime table',
 	toolbar:' undo redo | fontsizeselect | bold italic underline  | link image  | codesample | preview | insertdatetime | table | forecolor backcolor ltr rtl | alignleft aligncenter alignright alignjustify | fullscreen  ',
    menubar: 'edit insert view format table tools help textcolor colorpicker',
   elementpath: false,
    convert_urls: false,
     branding: false,
    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
    theme: 'modern',

   images_dataimg_filter: function(img) {
   	   return img.hasAttribute('internal-blob');
  },
  
   images_upload_url: $url,
   images_reuse_filename: false,
   indentation : '20pt',
   indent_use_margin: true
  });

  </script>
@endsection
<!--eleTree-checkbox-checked-->