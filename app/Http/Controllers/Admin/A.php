<?php
namespace App\Http\Controllers\Admin;
use  App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
class A extends Controller{
	 function __construct()
    {	
    	$this->middleware(['signed'])->only(['update','destroy','edit']);
        $this->_init();
    }
    function _init(){

    }


 	
}