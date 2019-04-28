<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;
use Helper;

class PostController extends Controller
{
   
    public function index()
    {
         $currentUser = Helper::staticInfo();

        $inventory = DB::table('inventory')
        ->select('inventory_id', 'inventory_item','inventory_brand','inventory_model','inventory_description','cost','inventory_serial_no','inventory_supplier','date_received','inventory_status','inventory_type','created_at','updated_at')->get();
        return view('Admin.flashdrive',compact('inventory','currentUser'));
    }

    public function delete(Request $request)
    {

        DB::table('inventory')->where('inventory_id', $request->input('in_id'))->delete();
        return redirect()->route('posts');
        
    }
}