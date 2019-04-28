<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Helper;
class PageControl extends Controller
{

public function index(){
	return view ('Admin.index');
}
public function inventory(){
	return view ('Admin.inventory');
}
public function purchase(){
	return view ('Admin.purchases');
}
public function replace(){
	return view ('Admin.replacement');
}
public function settings(){
	return view ('Admin.settings');
}
public function register(){
	return view ('Admin.register');
}
public function addPurchase(){
	return view ('Admin.addpurchase');
}
public function addreplacement(){
	return view ('Admin.addreplacement');
}
public function editaccount(){
	return view ('Admin.editaccount');
}
public function createaccount(Request $request){
	$currentUser = Helper::staticInfo();
	$posts = $users = DB::table('users')
            ->select('user_id',\DB::raw('CONCAT(first_name," ", last_name) AS fullname'),'username','password','last_login')->get();
	return view ('Admin.settings-createaccount',compact('currentUser','posts'));
}
}
