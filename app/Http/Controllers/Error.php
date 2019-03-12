<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class Error extends Controller
{
    function __invoke(Request $r){
    Log::channel('error')->error('IP:'.$r->getClientIp().'URL:['.$r->url().']');
   	return L('e');
   	// return view('lose')->response(['error'=>1,'status'=>404,'message'=>'This page no longer exists'],404)->header('Content-Type', 'text/plain');
	}
}
