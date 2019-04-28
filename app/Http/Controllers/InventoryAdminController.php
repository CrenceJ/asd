<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InventoryModel;
use Helper;
use DB;
class InventoryAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all()->distinct()->get();;
        // $posts = DB::select('SELECT DISTINCT inventory_item, inventory_brand, inventory_description, inventory_supplier, date_received FROM inventory')->distinct()->get();
        // $posts = DB::select('');
        $currentUser = Helper::staticInfo();
        $posts = $users = DB::table('inventory')
            ->select('inventory_id','inventory_item','inventory_brand','inventory_description', 'inventory_supplier', 'date_received',\DB::raw('COUNT(inventory_item)as count'))
            ->groupBy('inventory_item')
            ->where('inventory_status', '=', 'Available')
            ->get();
        return view('Admin.inventoryPage',compact('currentUser','posts'));
    }

   

    }

   