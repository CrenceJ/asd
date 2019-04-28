<?php

namespace App\Http\Controllers;
use Auth;
use Helper;
use App\InventoryModel;
use App\ServicesModel;
use App\SalesModel;
use App\ClientsModel;
use PDF;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    //
    private $inventories;
    private $services;
    private $sales;
    private $clients;

    public function __construct(InventoryModel $inventories, ServicesModel $services, SalesModel $sales, ClientsModel $clients)
    {
        $this->inventories=$inventories;
        $this->services=$services;
        $this->sales=$sales;
        $this->clients=$clients;
    }
    public function index()
    {
        $currentUser = Helper::staticInfo();
        $myServiceCount = $this->services::where('user_id', '=', Auth::user()->user_id)->count();
        $allServiceCount = $this->services->count();
        $unclaimedCount = $this->services::where('status', '=', 'Done')->count();
        $inventoriesCount = $this->inventories::where('inventory_status', '=', 'Available')->count();
        $allSalesCount = $this->sales->sum('cost');
        $CustomerCount = $this->clients->count();

        return view('Admin.index', compact('currentUser','allServiceCount', 'inventoriesCount', 'myServiceCount', 'unclaimedCount', 'allSalesCount', 'CustomerCount'));
    }
}
