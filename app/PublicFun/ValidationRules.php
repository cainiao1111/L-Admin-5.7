<?php

function ValidationRules($data,$request){
			$rule = $messages = [];
	      foreach($data as $k => $v){
            $str = 'bail';
            foreach($v as $kk => $vv){
            $str .='|'.$kk;
                if(strpos($kk,':')){
                   $mesname = $k.'.'.explode(':',$kk)[0];
                }else{
                   $mesname = $k.'.'.$kk;
                }
                
                if(isset($vv[1])){
                  $messages[$mesname][$vv[1]] = $vv[0];
                }else{
                  $messages[$mesname] = $vv[0];
                }

                 
            }
            $rule[$k] = $str;
        	}
        return  Validator::make($request->all(), $rule,$messages);
}

function AB($message){
     if($message){
        return back()->with('message','添加成功!');
         }else{
        return back()->with('message','添加失败!')->withInput();
      }
}