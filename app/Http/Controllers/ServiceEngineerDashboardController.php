<?php

namespace App\Http\Controllers;
use Auth;
use Helper;
use App\InventoryModel;
use App\ServicesModel;
use PDF;
use Illuminate\Http\Request;

class ServiceEngineerDashboardController extends Controller
{
    //
    private $inventories;
    private $services;

    public function __construct(InventoryModel $inventories, ServicesModel $services)
    {
        $this->inventories=$inventories;
        $this->services=$services;
    }
    public function index()
    {
        $currentUser = Helper::staticInfo();
        $myServiceCount = $this->services::where('user_id', '=', Auth::user()->user_id)->count();
        $allServiceCount = $this->services->count();
        $unclaimedCount = $this->services::where('status', '=', 'Done')->count();
        $inventoriesCount = $this->inventories->count();

        return view('client_module.client_home', compact('currentUser','allServiceCount', 'inventoriesCount', 'myServiceCount', 'unclaimedCount'));
    }
}
