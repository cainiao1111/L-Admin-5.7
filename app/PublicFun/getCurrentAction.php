<?php

/**
 * 获取 控制器名称,获取方法名称 进行权限验证 作用 
 */

//if(!function_exists('getCurrentAction')){
	function getCurrentAction(){
	 $action = \Route::current()->getActionName();
	   list($class, $method) = explode('@', $action);
   		$arrs = ['controller' => $class, 'method' => $method];
   		$arr = explode('\\',$arrs['controller']);
   		$arrs['model'] = $arr[3];
   		// $arrs['controller'] = substr($arr[4],0,-10);
      if(isset($arr[4])){
        $arrs['controller'] = $arr[4]; 
      } 
      
   		return $arrs;
	}
//}



/**
 * 视图
 */

//if(!function_exists('output')){ 
//  function output()
// {	
// 	$arr = getCurrentAction();
//   return $arr['model'].'.'.$arr['controller'].'.'.$arr['method'];
// }

//}



 function output()
{ 
  $arr = isset($GLOBALS['d']['mcm'])?GG('mcm'):getCurrentAction();
  return $arr['model'].'.'.$arr['controller'].'.'.$arr['method'];
}

/**
 *V
 */
//if(!function_exists('V')){
  function V($b=''){
    return view(output(),['d'=> isset($GLOBALS['d'])?$GLOBALS['d']:[],'b'=>$b]);
  }
//}

/**
 * G
 */
//if(!function_exists('G')){
function G($name,$data){
  $GLOBALS['d'][$name] = $data;
}
//}
function GG($name){
  return  $GLOBALS['d'][$name];
}

// function SV($a = []){
//   $arr = getCurrentAction();
//   return view($arr['model'].'.'.$arr['controller'].'.'.$arr['method'],$a);
// }

function L($l = 'lose'){
  return response()->view($l,[],404);
}