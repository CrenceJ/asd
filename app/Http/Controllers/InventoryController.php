<?php

namespace App\Http\Controllers;

use App\InventoryModel;
use Helper;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //
    public function index() 
    {
        $currentUser = Helper::staticInfo();
        $inventories = InventoryModel::all();

        return view('client_module.inventory', compact('currentUser', 'inventories'));
    }

    public function filter(Request $request)
    {
        $filter = $request->input('filter');

        if($filter == 'all') {
            $inventories = InventoryModel::all();
        }else{
            $inventories = InventoryModel::where('inventory_status', '=', $filter)->get();
        }

        $currentUser = Helper::staticInfo();

        return view('client_module.inventory', compact('currentUser', 'inventories'));


    }
}
