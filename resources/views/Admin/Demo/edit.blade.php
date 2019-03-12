@extends('Admin.A.vessel')
@section('content')
<link rel="stylesheet" href="./a/css/photoviewer.css">
<div class="layui-field-box">
<form class="layui-form layui-form-pane" method="post">
@csrf
<input type="hidden" name="_method" value="PUT"/>
	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>Demo名称</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="name" value="{{$b['r']->name}}"  maxlength="20"  autocomplete="off" lay-verify="required" placeholder="请输入名称" class="layui-input">
    </div>
     <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> Demo的名称</div>
  </div>

	 <div class="layui-form-item">
    <label class="layui-form-label"><span class="x-red">*</span>Demo排序</label>
    <div class="layui-input-inline">
      <input type="text" required="required" name="order_by" value="{{$b['r']->order_by}}"  maxlength="4"  autocomplete="off" lay-verify="required|number" placeholder="请输入名称" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux layui-icon layui-icon-tips"> Demo的排序,越大越在前</div>
  </div>

 <div class="layui-form-item">
<div class="layui-upload">
  <button type="button" class="layui-btn" id="test1">上传图片</button>
  <p type="button" class="layui-btn  layui-icon layui-icon-picture-fine layui-btn-normal" > 历史图片</p>
  <div class="layui-upload-list">
    <img src="{{$b['r']->img}}" alt="" id="imageshow" class="view_image" />
      <input type="hidden"  name="img" id="imagevalue" value="{{$b['r']->img}}"  autocomplete="off" lay-verify="imagevalue"  class="layui-input">
  
  </div>
</div>   

</div>   


   <div class="layui-form-item layui-form-text">
    <label class="layui-form-label"><span class="x-red">*</span>简介</label>
    <div class="layui-input-block">   	
    	  <textarea placeholder="请输入简介" name="account" maxlength="255" lay-verify="required" class="layui-textarea">{{$b['r']->account}}</textarea>  
    </div>
  </div>

 <div class="layui-form-item" >

	<div id='text'>{!!$b['r']->text!!}</div>

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
    @if(PV($d,'update'))
  <div class="layui-form-item">
    <button class="layui-btn"  lay-submit="" lay-filter="demo2">保存</button>
    <input type="reset" class="layui-btn layui-btn-primary" value="重置" />
   <button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
  </div>
  @endif
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
					 	}
          });
          
   	//图片预览
 $('#imageshow').click(function(e){
  e.preventDefault();
  var $this =  $(this);
  var items = [];
  items.push({ src: $this.attr('src')});
  var  options = {index: $this.index()};
  new PhotoViewer(items, options);	
  });

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
    },accept:'image',acceptMime: 'image/*',size:{{$b['size']}}
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