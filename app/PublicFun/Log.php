<?php

 	function create_log($r,$bool,$db,$table,$data){
 	if($bool){
 		$a = 'info';
 		$b = 'true';
 		$c = '成功';
 	}else{
 		$a = 'error';
 		$b = 'false';
 		$c = '失败';
 	}
 	$arr = [
 	'IP' =>$r->getClientIp(),
 	'操作账号ID'=>session('admin_user_id'),
 	'mcm' =>GG('mcm'),
 	'名称'=>$db,
 	'table' =>$table,
 	'id'=>$bool,
 	'数据'=>$data
 	];
 	Log::channel('create_'.$b)->$a('保存'.$c,$arr);
 	}

 	function update_log($r,$bool,$db,$table,$data,$id){
 	if($bool){
 		$a = 'info';
 		$b = 'true';
 		$c = '成功';
 	}else{
 		$a = 'error';
 		$b = 'false';
 		$c = '失败';
 	}
 	 $arr = [
 	'IP' =>$r->getClientIp(),
 	'操作账号ID'=>session('admin_user_id'),
 	'mcm' =>GG('mcm'),
 	'名称'=>$db,
 	'table' =>$table,
 	'id'=>$id,
 	'数据'=>$data
 	];

 	Log::channel('update_'.$b)->$a('修改'.$c,$arr);

 	}


 	function delete_log($r,$bool,$db,$table,$id){
 	if($bool){
 		$a = 'info';
 		$b = 'true';
 		$c = '成功';
 	}else{
 		$a = 'error';
 		$b = 'false';
 		$c = '失败';
 	}
 	 $arr = [
 	'IP' =>$r->getClientIp(),
 	'操作账号ID'=>session('admin_user_id'),
 	'mcm' =>GG('mcm'),
 	'名称'=>$db,
 	'table' =>$table,
 	'id'=>$id,
 	];

 	Log::channel('delete_'.$b)->$a('删除'.$c,$arr);

 	}