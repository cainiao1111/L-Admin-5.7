@extends('Admin.Index.sidebar')
@section('contents')
    <!-- 顶部开始 -->
    <div class="container">
        <div class="logo"><a href="./index.html">{{$b['r']->admin_name}}</a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="iconfont">&#xe699;</i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
			<li class="layui-nav-item to-index"><a onclick="javascript: history.go(0);" >刷新</a></li>
        	@if(config('app.debug'))
        	<li class="layui-nav-item to-index">调试开启</li>
        	@endif
        	
        @if($b['super'] == 1)
          <li class="layui-nav-item">
            <a href="javascript:;">+ Super </a>
            <dl class="layui-nav-child"> 
            @if(session('admin_super_id'))
             <dd> <a onclick="x_admin_show('Super改密','{{URL::signedRoute('superedit')}}')">Super改密</a></dd>
			 <dd> <a href="{{url('/super_quit')}}">Super退出</a></dd>   
            @else
			 <dd> <a href="{{URL::signedRoute('superl')}}">Super模式</a></dd>
			@endif
            </dl>
          </li>
		@endif

        </ul>
        <ul class="layui-nav right" lay-filter="">			
          <li class="layui-nav-item">
            <a href="javascript:;">个人信息</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a onclick="x_admin_show('基本资料','{{URL::signedRoute('myuseredit')}}')">基本资料</a></dd>
              <dd><a onclick="x_admin_show('密码修改','{{URL::signedRoute('mypassedit')}}')">密码修改</a></dd>
              <dd><a href="{{url('/login')}}">安全退出</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item to-index"><a  onclick="x_admin_show('首页','{{url('/')}}')">前台首页</a></li>
        </ul>
       
    </div>
    <!-- 顶部结束 -->
    <!-- 中部开始 -->
    <!-- 右侧主体开始 -->
    <div class="page-content">
        <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
          <ul class="layui-tab-title">
            <li class="home"><i class="layui-icon">&#xe628;</i>控制面板</li>
          </ul>
          <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <iframe src='{{url('platformData')}}' frameborder="0" scrolling="yes" class="x-iframe"></iframe>
            </div>
          </div>
        </div>
    </div>
    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
    <div class="footer">
        <div class="copyright">{{$b['r']->admin_foot}}</div>  
    </div>
    <!-- 底部结束 -->
@endsection