<?php

//if(!function_exists('mdPassword')){
	function MDP($pass){
		return md5('password:'.$pass.'_0+q-w+e');
	}
//}

	function MDV($mt,$id){
		return md5($mt.'validated:'.$id.'_1+q-w+e');
	}

	function MDSP($pass){
		return md5('super_password:'.$pass.'_2+q-w+e');
	}
	function MDSV($mt,$id){
		return md5($mt.'super_validated:'.$id.'_3+q-w+e');
	}

	function PV($d,$method){
		return !empty(session('admin_super_id')) || (array_key_exists($d['mcm']['controller'],$d['c_token']) && array_key_exists($method,$d['c_token'][$d['mcm']['controller']]));
	}