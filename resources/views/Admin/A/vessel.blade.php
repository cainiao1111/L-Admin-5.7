
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="robots" content="NOINDEX,NOFOLLOW,noarchive" />
    <link rel="shortcut icon" href="./a/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="./a/css/font.css">
	<link rel="stylesheet" href="./a/css/xadmin.css">
	<link rel="stylesheet" href="./a/css/rightClick.css">
	<title>*</title>
	<noscript>
 	<style type="text/css">
 		body{
 			display: none;
 		}
 	</style>
 	</noscript>
	@yield('css')
</head>
<body class="layui-anim layui-anim-fadein">
@yield('content')   

<script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="./a/lib/layui/layui.js" charset="utf-8"></script>
<script type="text/javascript" src="./a/js/xadmin.js"></script>
<script type="text/javascript" src="./a/js/rightClick.js"></script>
<script>
 	
	history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
    });
  layui.use('form', function(){
  	@if(session('message'))
    layer.msg('{{session('message')}}');
     @endif
     @if($errors->any())
       layer.msg('{{$errors->all()[0]}}');
     @endif
  $('#search_show').click(function(){
	$('#search').css('display','block');
});
$('#search_close').click(function(){
	$('#search').css('display','none');
});
$('#top_click').click(function(){
	window.scrollTo(0,0);  
});
  })
  
//		$(document).ready(function(){
//			var rcm = window.RMenu;
//			rcm.init({
//				area:'body',
//				items:{
//
//					"refresh":{name:"刷新",icon:'&#xe6aa;'},
//					"close":{name:"关闭",icon:'&#xe69a;'}
//					
//				},
//				callback:function(res){
//				 if(res.data == 'refresh'){
//						window.location.reload();
//					}else if(res.data == 'close'){
//						$('.RCM-container').css('display','none');
//					}
//				}
//			})
//		});

 </script>

<!--@if(config('app.debug') )
<script type="text/javascript" src="./a/js/CLog.js"></script>
<script>
 	screenLog.init();
	console.log('APP_DEBUG:TRUE');
	console.log('────────────────────────────');
</script>
@endif-->
 @yield('js')


</body>
</html>
