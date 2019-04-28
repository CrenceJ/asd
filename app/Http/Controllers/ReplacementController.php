<?php

namespace App\Http\Controllers;
use Helper;
use DB;
use App\ReplaceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use App\InventoryModel;
use Carbon\Carbon;


class ReplacementController extends Controller
{
	public function replace(){
		$currentUser = Helper::staticInfo();
		$replace = $users = DB::table('replacement')
		->select('replace_id','srf_no','credit_no','item', 'brand', 'description','price','supplier','date_recieved','quantity')
		->get();
		return view('Admin.replacement',compact('replace','currentUser'));
	}
	
}
