<?php

namespace App\Http\Controllers;

use App\ServicesModel;
use App\ClientsModel;
use App\InventoryModel;
use App\SalesModel;
use App\OrdersModel;
use App\OrderDetailsModel;
use Helper;
use Auth;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    //
    public function index()
    {
        $currentUser = Helper::staticInfo();
        $displaySales = DB::select('SELECT o.order_id, o.or_number, CONCAT(c.first_name, " ", c.last_name) AS name, o.order_type, s.cost, s.created_at FROM
                    clients c INNER JOIN orders o INNER JOIN sales s ON s.order_id = o.order_id AND o.client_id = c.client_id');

        $orderDetails = DB::select('SELECT o.order_id, inventory_item, i.cost from ORDER_details o INNER JOIN inventory i ON o.inventory_id = i.inventory_id;');
        
        return view('client_module.sales', compact('currentUser', 'displaySales', 'orderDetails'));
    }
}
