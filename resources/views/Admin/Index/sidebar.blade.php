@extends('Admin.A.vessel')
@section('content')
<link rel="stylesheet" href="./a/css/aliico.css">
	<div class="left-nav">
      <div id="side-nav  ">
        <ul id="nav">
        	
        	@if( !empty(session('admin_super_id')) && session('admin_super_id') == session('admin_user_id'))
        	<!--超级管理-->
        	  <li>
                <a href="javascript:;">
                    <i class="iconfont">&#xe602;</i>
                    <cite>超级管理</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                	@php
                	$arr = [
                		['n'=>'管理员','c'=>'Xadmin','i'=>'&#xe6fb;'],
                		['n'=>'角色','c'=>'Part','i'=>'&#xe627;'],
                		['n'=>'权限','c'=>'Permissions','i'=>'&#xe61e;']
                	];
                	@endphp
                	@foreach(getYield($arr) as $v)
                	  <!--{{$v['n']}}管理-->
                    <li>
                        <a href="javascript:;">
                            <i class="iconfont">{!!$v['i']!!}</i>
                            <cite>{{$v['n']}}管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                       <li>
                                <a _href="{{url($v['c'])}}">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$v['n']}}列表</cite>
                                    
                                </a>
                            </li >  
                              <li>
                                <a _href="{{url($v['c'].'_create')}}">
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$v['n']}}添加</cite>
                                    
                                </a>
                            </li >  
                        </ul>
                    </li>
                    <!--end{{$v['n']}}管理-->
                	@endforeach
                	
                			    <li>
                        <a href="javascript:;">
                            <i class="iconfont">&#xe601;</i>
                            <cite>文件管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                    	<li>
                       <a _href="{{url('super_upload_files')}}">
                          <i class="iconfont">&#xe6a7;</i>
                         <cite>公共图片管理</cite>
                                    
                       </a>
                     </li>
                        </ul>
                    </li>
                	
                	    <li>
                        <a href="javascript:;">
                            <i class="iconfont">&#xe62e;</i>
                            <cite>系统管理</cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                    	<li>
                       <a _href="{{url('super_logs')}}">
                          <i class="iconfont">&#xe6a7;</i>
                         <cite>系统日志</cite>
                                    
                       </a>
                     </li>
                     @if(session('admin_user_id') == 1)
                     <li>
                       <a _href="{{url('super_artisan')}}">
                          <i class="iconfont">&#xe6a7;</i>
                         <cite>Artisan 控制台</cite>
                                    
                       </a>
                     </li>
                     @endif
                      <li>
                       <a _href="{{url('super_route')}}">
                          <i class="iconfont">&#xe6a7;</i>
                         <cite>后台路由</cite>
                                    
                       </a>
                     </li>
                     
                     	<li>
                       <a _href="{{url('super_basis')}}">
                          <i class="iconfont">&#xe6a7;</i>
                         <cite>基础配置</cite>
                                    
                       </a>
                     </li>
                     
                        </ul>
                    </li>
		
                </ul>
            </li>
            <!--超级管理结束-->
               @foreach(getYield($b['p']) as $v)
                @if($v->fid == 0 && $v->type == 1)
                <!--{{$v->name}}-->
                 <li>
                <a href="javascript:;">
                    <i class="layui-icon  {{$v->icon}}"></i>
                    <cite>{{$v->name}}</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                
                
                <ul class="sub-menu">
                @foreach(json_decode($v->content) as $kkk => $vvv)
                       @if( isset($vvv->s) && !isset($vvv->api)   && $vvv->req == 'get')
                       		
                            <li>
                            	
                                <a _href="{{url($vvv->v=='index'?$v->e_name:$v->e_name.'_'.$vvv->v)}}">                                	
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$vvv->k}}</cite>
                                    
                                </a>
                            </li > 
                            
                        @endif
                        @endforeach 
                        <!---->
                    @foreach(getYield($b['p']) as $vv)
                    @if( $vv->type == 2 && $vv->fid == $v->id)
                    <!--{{$vv->name}}-->
                    <li>
                        <a href="javascript:;">
                            <i class="layui-icon  {{$vv->icon}}"></i>
                            <cite>{{$vv->name}}</cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                            @foreach(json_decode($vv->content) as $kkk => $vvv)
                      
                          @if( isset($vvv->s) && !isset($vvv->api)   && $vvv->req == 'get')
                       		
                            <li>
                            	
                                <a _href="{{url($vvv->v=='index'?$vv->e_name:$vv->e_name.'_'.$vvv->v)}}">                                	
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$vvv->k}}</cite>
                                    
                                </a>
                            </li > 
                            
                        @endif
                            
                            @endforeach  
                        </ul>
                    </li>
                    <!--{{$vv->name}}end-->
                    @endif
                     @endforeach
                </ul>
            </li>
            <!--{{$v->name}}end-->
            @elseif($v->fid == 0 && $v->type == 2)
            <!--{{$v->name}}-->
            <li>
                <a href="javascript:;">
                     <i class="layui-icon  {{$v->icon}}"></i>
                    <cite>{{$v->name}}</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                           @foreach(json_decode($v->content) as $kkk => $vvv)
         			 @if( isset($vvv->s) && !isset($vvv->api)  && $vvv->req == 'get')
                       		
                            <li>
                            	
                                <a _href="{{url($vvv->v=='index'?$v->e_name:$v->e_name.'_'.$vvv->v)}}">                                	
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$vvv->k}}</cite>
                                    
                                </a>
                            </li > 
                            
                        @endif
                                        
                            @endforeach  
                </ul>
            </li>
             <!--{{$v->name}}-->
             @endif
             
            @endforeach
            @else
        	
        	@php
        	
        	$access = json_decode(unserialize(GG('admin'))->convenient_access,true);
     
        	@endphp
        	
            @foreach(getYield($b['p']) as $v)
                @if($access != null && array_key_exists($v->e_name,$access) && $v->fid == 0 && $v->type == 1)
                <!--{{$v->name}}-->
                 <li>
                <a href="javascript:;">
                    <i class="layui-icon  {{$v->icon}}"></i>
                    <cite>{{$v->name}}</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                
                
                <ul class="sub-menu">
                @foreach(json_decode($v->content) as $kkk => $vvv)
                       @if(array_key_exists($vvv->v,$access[$v->e_name]) && isset($vvv->s) && !isset($vvv->api)  && $vvv->req == 'get' )
                       		
                            <li>
                            	
                                <a _href="{{url($vvv->v=='index'?$v->e_name:$v->e_name.'_'.$vvv->v)}}">                                	
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$vvv->k}}</cite>
                                    
                                </a>
                            </li > 
                            
                        @endif
                        @endforeach 
                        <!---->
                    @foreach(getYield($b['p']) as $vv)
                    @if(array_key_exists($vv->e_name,$access[$v->e_name]) && $vv->type == 2 && $vv->fid == $v->id)
                    <!--{{$vv->name}}-->
                    <li>
                        <a href="javascript:;">
                            <i class="layui-icon  {{$vv->icon}}"></i>
                            <cite>{{$vv->name}}</cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                            @foreach(json_decode($vv->content) as $kkk => $vvv)
                      
                          @if(array_key_exists($vvv->v,$access[$v->e_name][$vv->e_name]) && isset($vvv->s) && !isset($vvv->api)   && $vvv->req == 'get')
                       		
                            <li>
                            	
                                <a _href="{{url($vvv->v=='index'?$vv->e_name:$vv->e_name.'_'.$vvv->v)}}">                                	
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$vvv->k}}</cite>
                                    
                                </a>
                            </li > 
                            
                        @endif
                            
                            @endforeach  
                        </ul>
                    </li>
                    <!--{{$vv->name}}end-->
                    @endif
                     @endforeach
                </ul>
            </li>
            <!--{{$v->name}}end-->
            @elseif($access != null &&  array_key_exists($v->e_name,$access) && $v->fid == 0 && $v->type == 2 )
            <!--{{$v->name}}-->
            <li>
                <a href="javascript:;">
                     <i class="layui-icon  {{$v->icon}}"></i>
                    <cite>{{$v->name}}</cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>
                <ul class="sub-menu">
                           @foreach(json_decode($v->content) as $kkk => $vvv)
         			 @if(array_key_exists($vvv->v,$access[$v->e_name]) && isset($vvv->s) && !isset($vvv->api)  && $vvv->req == 'get'  )
                       		
                            <li>
                            	
                                <a _href="{{url($vvv->v=='index'?$v->e_name:$v->e_name.'_'.$vvv->v)}}">                                	
                                    <i class="iconfont">&#xe6a7;</i>
                                    <cite>{{$vvv->k}}</cite>
                                    
                                </a>
                            </li > 
                            
                        @endif
                                        
                            @endforeach  
                </ul>
            </li>
             <!--{{$v->name}}-->
             @endif
            @endforeach
       		@endif
        </ul>
      
      </div>
    </div>
    <!-- <div class="x-slide_left"></div> -->
    <!-- 左侧菜单结束 -->
@yield('contents')

@endsection