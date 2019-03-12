<?php

function getYield($arr){
	for ($i=0; $i < count($arr) ; $i++) { 
		yield $arr[$i];
	}
}

// 权限树

function ConvenientAccess($row,$b = ''){
	 $arr = [];
      foreach(getYield($row) as $v){
        if($v->fid == 0 && $v->type == 1){
            $arr[$v->id]['id'] = 1;
            $arr[$v->id]['label'] = $v->name;
            // if(isset($b[$v->e_name])){  
            // $arr[$v->id]['checked'] = "checked";
            // }
            // $arr[$v->id]['key'] = $v->e_name;
            $index = 0;
            $newArr = json_decode($v->content);
            foreach(getYield($newArr) as $kk => $vv){
                $arr[$v->id]['children'][$index]['id'] = $v->e_name.'_'.$vv->v;
                $arr[$v->id]['children'][$index]['label'] = $vv->k;
                $arr[$v->id]['children'][$index]['isLeaf'] = true;
                 if(isset($b[$v->e_name][$vv->v])){  
                $arr[$v->id]['children'][$index]['checked'] = "checked";
                }
                // $arr[$v->id]['children'][$index]['key'] = $vv->v;
                $index++;
            }
            foreach(getYield($row) as $vvv){
                if($vvv->fid == $v->id && $vvv->type == 2){
                $arr[$v->id]['children'][$index]['id'] =1;
                $arr[$v->id]['children'][$index]['label'] = $vvv->name;  
                $arr[$v->id]['children'][$index]['isLeaf'] = true;
                // if(isset($b[$v->e_name][$vvv->e_name])){  
                // $arr[$v->id]['children'][$index]['checked'] = "checked";
                // }
                // $arr[$v->id]['children'][$index]['key'] = $vvv->e_name;
                $newArr = json_decode($vvv->content);
         
                    $i = 0;
                    foreach(getYield($newArr) as $kkkk => $vvvv){

                   $arr[$v->id]['children'][$index]['children'][$i]['id'] = $v->e_name.'_'.$vvv->e_name.'_'.$vvvv->v;
                   $arr[$v->id]['children'][$index]['children'][$i]['label']= $vvvv->k;
                    $arr[$v->id]['children'][$index]['children'][$i]['isLeaf'] = true;
                    if(isset($b[$v->e_name][$vvv->e_name][$vvvv->v])){  
                     $arr[$v->id]['children'][$index]['children'][$i]['checked'] = "checked";
                    }

                    // $arr[$v->id]['children'][$index]['children'][$i]['key'] = $vvvv->v;
                   $i++;
                    }
                     $index++;
                }
            }

        }else if($v->fid == 0 && $v->type == 2){
            $arr[$v->id]['id'] = 1;
            $arr[$v->id]['label'] = $v->name;
            // if(isset($b[$v->e_name])){  
            // $arr[$v->id]['checked'] = "checked";
            // }
            $index = 0;
            $newArr = json_decode($v->content);
             foreach(getYield($newArr) as $kk => $vv){
                $arr[$v->id]['children'][$index]['id'] = $v->e_name.'_'.$vv->v;
                $arr[$v->id]['children'][$index]['label']= $vv->k;
                $arr[$v->id]['children'][$index]['isLeaf'] = true;
                if(isset($b[$v->e_name][$vv->v])){  
                    $arr[$v->id]['children'][$index]['checked'] = "checked";
                 }

               // $arr[$v->id]['children'][$index]['checked'] ="checked";
                // $arr[$v->id]['children'][$index]['key'] = $vv->v;
                $index++;
            }
        }
      }
      return $arr;
}

function ConvenientAccessToJson($string){
        $arr = [];
        foreach(getYield(explode(',', $string)) as $v){
            $a = explode('_', $v);
            if(count($a) == 2){
                $arr[$a[0]][$a[1]] = 1;
            }else if(count($a) == 3){
                $arr[$a[0]][$a[1]][$a[2]] = 1;
            }
        
        }
        return json_encode($arr);
}
function ConvenientTokenToJson($string){
    $arr = [];
      foreach(getYield(explode(',', $string)) as $v){
            $a = explode('_', $v);
            if(count($a) == 2){
                $arr[$a[0]][$a[1]] = 1;
            }else if(count($a) == 3){
                 $arr[$a[1]][$a[2]] = 1;
            }
        
    }
     return json_encode($arr);
}