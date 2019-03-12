<?php

namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminMode extends Model
{
    protected $table = 'a_admin';

    protected function first_admin($where){
    	return self::from($this->table.' as a')->where($where)->leftjoin('a_role as b','b.id','=','a.r_id')->select('a.*','b.id as bid','b.convenient_token','b.convenient_access','b.state as bstate')->first();
    }
}
