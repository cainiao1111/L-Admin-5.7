@extends('Admin.A.vessel')
@section('content')
<style type="text/css">
	#route_content{
		border: 4px solid #aaa;
		padding: 1vh 1vw;
		min-height: 33vh;
		overflow-y:auto;
		max-height: 60vh;
	}

</style>
<link rel="stylesheet" href="./a/codesample/css/prism.css">
<script src="./a/codesample/css/prism.js" type="text/javascript" charset="utf-8"></script>

<div class=" layui-field-box">
<pre id="route_content" class="language-php"><code id="code">//以下必须有权限可使用 || 有超级管理权限
{{$b}}</code>
</pre>

	<p class="layui-btn layui-btn-normal " id="copy_route">复制</p>
	   <button class="layui-btn layui-btn-normal" onclick="javascript: history.go(0);"><i class="layui-icon">&#xe9aa;</i></button>
</div>

@endsection
@section('js')
<script>
	layui.use(['layer'], function(){
          $ = layui.jquery;
    $('#copy_route').click(function(){
    	layer.msg('复制成功!');
    	copyText($('#code').text());
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
