
@extends('Admin.A.vessel')
@section('content')

<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">日志系统</div>

    <ul class="layui-nav layui-layout-left">
    	     @if($current_file && session('admin_user_id') == 1)
          <li class="layui-nav-item"> <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
            <span class="fa fa-download"></span> 下载
          </a></li>
          -
          <li class="layui-nav-item"> <a id="clean-log" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
            <span class="fa fa-sync"></span> 清空
          </a></li>
          -
           <li class="layui-nav-item"><a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
            <span class="fa fa-trash"></span> 删除文件
          </a></li>
          @if(count($files) > 1)
            -
             <li class="layui-nav-item"><a id="delete-all-log" href="?delall=true{{ ($current_folder) ? '&f=' . \Illuminate\Support\Facades\Crypt::encrypt($current_folder) : '' }}">
              <span class="fa fa-trash-alt"></span> Delete all files
            </a></li>
          @endif
        @endif
 
    </ul>

  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
      	   @foreach($folders as $folder)
          
            <li class="layui-nav-item"><a href="?f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}">
              <span class="fa fa-folder"></span> {{$folder}}
            </a></li>
            @if ($current_folder == $folder)
            
                @foreach($folder_files as $file)
                 <li class="layui-nav-item"> <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}&f={{ \Illuminate\Support\Facades\Crypt::encrypt($folder) }}"
                    class="list-group-item @if ($current_file == $file) llv-active @endif">
                    {{$file}}
                 </a> </li>
                @endforeach
            
            @endif
        
        @endforeach
        @foreach($files as $file)
         <li class="layui-nav-item"> <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
             class="list-group-item @if ($current_file == $file) llv-active @endif">
            {{$file}}
          </a>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  
  <div class="layui-body">


       <div class="layui-field-box">
<table class="layui-table"  lay-filter="demo">
  <thead>
  	 @if ($logs === null)
  	 <tr>
  	 		<th lay-data="{field:'message'}">消息</th>
  	 </tr>
  	 @else
    <tr>
    	   
              <th lay-data="{field:'level',width:80}">等级</th>
              <th lay-data="{field:'context',width:80}">源</th>
              <th lay-data="{field:'date',sort: true,width:200}">日期</th>
               
            <th lay-data="{field:'text'}">内容</th>
            <th lay-data="{field:'stack'}">stack</th>
             <th lay-data="{field:' in_file',width:80}"> in_file</th>
    </tr>
    @endif
  </thead>

</table>
       
      
      

    </div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
  </div>
</div>



@endsection
@section('js')

<script>
 @if ($logs === null)
 var data = [{'message':'Log file >50M, please download it.'}];
 @else
 var data = {!!json_encode($logs)!!};
 @endif

layui.use('table', function(){
  var table = layui.table;
  table.init('demo', {
  limit: 10 
,page:true
,data:data
}); 

});
</script>

@endsection
