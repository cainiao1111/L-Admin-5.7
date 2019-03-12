@extends('Admin.A.vessel')
@section('content')
<link rel="stylesheet" href="./a/css/photoviewer.css">
<div class="layui-field-box">
<table class="layui-table">
	 <colgroup>
    <col width="120">
  
    <col>
  </colgroup>
  <tbody>
    <tr>
      <td>名称</td>
      <td>{{$b['r']->name}}</td>
    </tr>

    <tr>
      <td>排序</td>
      <td>{{$b['r']->order_by}}</td>
 
 </tr>
 <tr>
      <td>图片</td>
      <td>
      	
      	<img src="{{$b['r']->img}}" alt="" id="imageshow" class="view_image" />
      </td>
 
 </tr>
      <tr>
      <td>描述</td>
      <td>{{$b['r']->account}}</td>
 
 </tr>
 <tr>
      <td>状态</td>
      <td>{{['停用','正常'][$b['r']->state]}}</td>
</tr>
</tbody>
</table>
<pre>{!!$b['r']->text!!}</pre>
</div> 
@section('js')
<script type="text/javascript" src="./a/js/photoviewer.js"></script>
<script type="text/javascript">
	          
   	//图片预览
 $('#imageshow').click(function(e){
  e.preventDefault();
  var $this =  $(this);
  var items = [];
  items.push({ src: $this.attr('src')});
  var  options = {index: $this.index()};
  new PhotoViewer(items, options);	
  });
</script>
@endsection
