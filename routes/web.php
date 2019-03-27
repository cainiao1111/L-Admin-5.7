<?php

/**
 * 没有的路由都走这↓
 */
Route::fallback('Error');

Route::middleware('throttle:120,1')->namespace('Admin')->group(function(){
	Route::get('/login','Login@index')->name('login');
	Route::post('/login','Login@login')->middleware('signed');
});

Route::middleware('admin')->namespace('Admin')->group(function(){
	//首页
	Route::get('/admin','Index@index');
	//平台数据
	Route::get('/platformData','Index@platformData');
	//密码修改
	 Route::get('/my_pass_edit','Index@edit');
	 Route::put('/my_pass_edit','Index@update')->name('mypassedit');
	 //资料修改
	 Route::get('/my_admin_edit','Index@editU');
	 Route::put('/my_admin_edit','Index@updateU')->name('myuseredit');
	 //图片上传接口 -- 
	 Route::post('adminapi/img/upload/{a}/{b}','Index@img_upload')->name('imgupload')->middleware('signed');
	 //历史图片
	 Route::get('picture.history.{t}.{dom}','Index@picture_history')->where('t','^[0-1]{1}$');
	 //退出
	 // Route::get('/user_quit','Index@quit');
	//验证签名->角色权限
	//超级管理员登录
	Route::get('/SuperModel','Super@index');
	Route::post('/SuperModel','Super@login')->name('superl');
	//以下必须有超级管理权限才可用 
	Route::middleware('SupraAuthorityFilter')->group(function(){
		// 超级密码修改
		Route::get('/super_edit','Super@edit');
		Route::put('/super_edit','Super@update')->name('superedit');
		//退出
		Route::get('/super_quit','Super@quit');
		//日志
		Route::get('/super_logs','Super@logs');
		//Artisan 控制台
		Route::get('/super_artisan','Super@artisan');
		Route::put('adminapi/super_artisan','Super@artisan_api')->name('superartisan')->middleware('signed');
		//后台路由
		Route::get('/super_route','Super@route');
		//上传文件管理
		Route::get('/super_upload_files','Super@upload_files');
		Route::post('adminapi/super/upload_{a}_{b}','Super@upload')->name('superupload')->middleware('signed');
		Route::delete('delete_api/super/image','Super@delete_image')->name('superdelete')->middleware('signed');
		//基础配置
		Route::get('/super_basis','Super@basis');
		Route::put('/super_basis','Super@basis_save');
		// Permissions 权限
		Route::resource('Permissions','Permissions', ['parameters' => [
    	'Permissions' => 'id'
		],'except'=>['destroy']]);
		Route::resources(['Part'=>'Part','Xadmin'=>'Xadmin'],['parameters'=>['Part'=>'id','Xadmin'=>'id']]);
		//api adminapi
		Route::prefix('adminapi')->group(function(){
			Route::put('Part/state_{id}','Part@state');			
			Route::prefix('Permissions')->group(function(){
				Route::put('state_{id}','Permissions@state');
				Route::put('weight_{id}','Permissions@weight');
				Route::put('none_{id}','Permissions@none');
			});
			Route::prefix('Xadmin')->group(function(){
				Route::put('state_{id}','Xadmin@state');
				Route::put('super_{id}','Xadmin@super');
				Route::put('none_{id}','Xadmin@none');
				Route::put('resetpass_{id}','Xadmin@resetpass');
			});

		});
	});

});


//以下必须有权限可使用 || 有超级管理权限[替换内容]
Route::middleware('admin','AuthorityFilter')->namespace('Admin')->group(function(){
Route::resource("Roles","Roles",['parameters' => ["Roles"=> 'id']]);
Route::put("adminapi/Roles/state_{id}","Roles@state");
Route::resource("Aadmin","Aadmin",['parameters' => ["Aadmin"=> 'id']]);
Route::put("adminapi/Aadmin/state_{id}","Aadmin@state");
Route::put("adminapi/Aadmin/resetpass_{id}","Aadmin@resetpass");
Route::resource("Demo","Demo",['parameters' => ["Demo"=> 'id']]);
Route::put("adminapi/Demo/state_{id}","Demo@state");
Route::put("adminapi/Demo/orderby_{id}","Demo@orderby");
Route::put("adminapi/Demo/deletedatas","Demo@deletedatas")->name("Demo.deletedatas")->middleware('signed');
});

//以下必须有权限可使用 || 有超级管理权限
//以下为开发版--上线需替换 超级管理/系统管理/后台路由 里的内容即可--不替换也行-就是慢一点
// Route::middleware('admin','AuthorityFilter')->namespace('Admin')->group(function(){
// 		$rec = ['index','create','store','show','edit','update','destroy'];
// 		$r = DB::table('a_permissions')->where(['state'=>1])->where('type','<>',3)->select('e_name','content')->get();
// 		foreach(getYield($r) as $v){
// 		$c = json_decode($v->content);
// 		$only = [];
// 		foreach($c as $k => $vv){
// 			if(in_array($vv->v, $rec)){
// 				$only[] = $vv->v;
// 				unset($c[$k]);
// 			}
// 		}
// 		Route::resource($v->e_name,$v->e_name,['parameters' => [
//     	$v->e_name=> 'id'
// 		],'only'=>$only]);
// 		foreach($c as $vvv){
// 			$name = $v->e_name.'/'.$vvv->v;
// 			            if($vvv->req == 'get'){
//                 $name = strtr($name, '/', '_');
//             }
                 
// 			if(isset($vvv->api)){
// 				$name = 'adminapi/'.$name;
// 			}

// 			if(isset($vvv->id)){
// 				$name .='_{id}';
// 			}
// 			if(isset($vvv->hash)){
// 			$hash = $v->e_name.'.'.$vvv->v;
// 			switch ($vvv->req) {
// 				case 'put':
// 				Route::put($name,$v->e_name.'@'.$vvv->v)->name($hash)->middleware('signed');	
// 					break;
// 				case 'delete':
// 				Route::delete($name,$v->e_name.'@'.$vvv->v)->name($hash)->middleware('signed');
// 					break;
// 				case 'post':
// 				Route::post($name,$v->e_name.'@'.$vvv->v)->name($hash)->middleware('signed');
// 					break;
// 				default:
// 				Route::get($name,$v->e_name.'@'.$vvv->v)->name($hash)->middleware('signed');
// 					break;
// 			}
// 		}else{
// 				switch ($vvv->req) {
// 				case 'put':
// 				Route::put($name,$v->e_name.'@'.$vvv->v);	
// 					break;
// 				case 'delete':
// 				Route::delete($name,$v->e_name.'@'.$vvv->v);
// 					break;
// 				case 'post':
// 				Route::post($name,$v->e_name.'@'.$vvv->v);
// 					break;
// 				default:
// 				Route::get($name,$v->e_name.'@'.$vvv->v);
// 					break;
// 			}
// 		}
// 		}
// 	}
// });
