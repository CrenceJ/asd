<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OrdersModel;
use Helper;
use DB;
use PDF;
class ReportsController extends Controller
{
    //
    public function index()
    {
        $currentUser = Helper::staticInfo();
        return view('client_module.reports', compact('currentUser'));
    }

    public function viewReport(Request $request)
    {
        switch($request->input('pdftype')) {
            case 'inventory':
                return $this->inventoryReport($request);
                break;
            case 'service':
                return $this->serviceReport($request);
                break;
            case 'order':
                return $this->orderReport($request);
                break;
            case 'sale':
                return $this->salesReport($request);
                break;
            default:
                return "Error, dont hack my system";
        }
    }

    public function inventoryReport($request) 
    {
        $inventory = array();
        $type = 'inventory';
        if($request->input('pdf') == 'daily') {
            $inventory = DB::select('SELECT * from inventory where DAY(created_at) = DAY(now()) AND YEAR(created_at) = YEAR(now()) AND MONTH(now()) = MONTH(created_at)');
        } else if($request->input('pdf') == 'monthly') {
            $inventory = DB::select('SELECT * from inventory where YEAR(created_at) = YEAR(now()) AND MONTH(now()) = MONTH(created_at)');
        } else if($request->input('pdf') == 'yearly') {
            $inventory = DB::select('SELECT * from inventory where YEAR(created_at) = YEAR(now())');
        } else if($request->input('pdf') == 'custom') {
            $start = $request->input('startdate');
            $end = $request->input('enddate');
            $inventory = DB::select("SELECT * from inventory where created_at BETWEEN '$start' AND '$end'");
        }

        if(sizeof($inventory)) {
            $pdf = PDF::loadView('client_module.reportdownload', compact('inventory', 'type'));
            return $pdf->download('inventory_'.date('Y-m-d').'.pdf');
       } else {
           return redirect()->route('reports')->with('noreport', 'zero');
       }

    }

    public function salesReport($request)
    {
        $sales = array();
        $type = 'sales';

        if($request->input('pdf') == 'daily') {
            $sales = DB::select('SELECT o.order_id, o.or_number, CONCAT(c.first_name, " ", c.last_name) AS name, o.order_type, s.cost, s.created_at FROM
                                        clients c INNER JOIN orders o INNER JOIN sales s ON s.order_id = o.order_id AND o.client_id = c.client_id
                                        WHERE DAY(s.created_at) = DAY(now()) AND YEAR(s.created_at) = YEAR(now()) AND MONTH(now()) = MONTH(s.created_at)');

        } else if($request->input('pdf') == 'monthly') {
            $sales = DB::select('SELECT o.order_id, o.or_number, CONCAT(c.first_name, " ", c.last_name) AS name, o.order_type, s.cost, s.created_at FROM
                                        clients c INNER JOIN orders o INNER JOIN sales s ON s.order_id = o.order_id AND o.client_id = c.client_id
                                        WHERE YEAR(s.created_at) = YEAR(now()) AND MONTH(now()) = MONTH(s.created_at)');

        } else if($request->input('pdf') == 'yearly') {
            $sales = DB::select('SELECT o.order_id, o.or_number, CONCAT(c.first_name, " ", c.last_name) AS name, o.order_type, s.cost, s.created_at FROM
                                        clients c INNER JOIN orders o INNER JOIN sales s ON s.order_id = o.order_id AND o.client_id = c.client_id
                                        WHERE YEAR(s.created_at) = YEAR(now())');

        } else if($request->input('pdf') == 'custom') {
            $start = $request->input('startdate');
            $end = $request->input('enddate');

            $sales = DB::select("SELECT o.order_id, o.or_number, CONCAT(c.first_name, ' ', c.last_name) AS name, o.order_type, s.cost, s.created_at FROM
                                        clients c INNER JOIN orders o INNER JOIN sales s ON s.order_id = o.order_id AND o.client_id = c.client_id
                                        WHERE s.created_at BETWEEN '$start' AND '$end'");
        }

        if(sizeof($sales)) {
            $pdf = PDF::loadView('client_module.reportdownload', compact('sales', 'type'));
            return $pdf->download('sales_'.date('Y-m-d').'.pdf');
       } else {
           return redirect()->route('reports')->with('noreport', 'zero');
       }
    }

    public function orderReport($request)
    {
        $orders = array();
        $type = 'order';

        if($request->input('pdf') == 'daily') {
            $ord = DB::select('SELECT * FROM orders o INNER JOIN clients ON o.client_id = clients.client_id WHERE DAY(o.created_at) = DAY(now())
                                AND MONTH(o.created_at) = MONTH(now()) AND YEAR(o.created_at) = YEAR(now())');

        } else if($request->input('pdf') == 'monthly') {
            $ord = DB::select('SELECT * FROM orders o INNER JOIN clients ON o.client_id = clients.client_id WHERE MONTH(o.created_at) = MONTH(now()) AND YEAR(o.created_at) = YEAR(now())');

        } else if($request->input('pdf') == 'yearly') {
            $ord = DB::select('SELECT * FROM orders o INNER JOIN clients ON o.client_id = clients.client_id WHERE YEAR(o.created_at) = YEAR(now())');

        } else if($request->input('pdf') == 'custom') {
            $start = $request->input('startdate');
            $end = $request->input('enddate');

            $ord = DB::select("SELECT * from orders o inner join clients on o.client_id = clients.client_id where o.created_at BETWEEN '$start' AND '$end'");
        }

        if(sizeof($ord)) {
            $pdf = PDF::loadView('client_module.reportdownload', compact('ord', 'type'));
            return $pdf->download('orders_'.date('Y-m-d').'.pdf');
       } else {
           return redirect()->route('reports')->with('noreport', 'zero');
       }

    }

    public function serviceReport($request)
    {
        $service = array();
        $type = 'service';

        if($request->input('pdf') == 'daily') {

            $serv = DB::select('SELECT srf_no, brand, warranty, description, STATUS, service_cost, created_at FROM services WHERE DAY(created_at) = DAY(now())
                    AND MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())');

        } else if($request->input('pdf') == 'monthly') {
            $serv = DB::select('SELECT srf_no, brand, warranty, description, STATUS, service_cost, created_at FROM services WHERE MONTH(created_at) = MONTH(now()) AND YEAR(created_at) = YEAR(now())');

        } else if($request->input('pdf') == 'yearly') {
            $serv = DB::select('SELECT srf_no, brand, warranty, description, STATUS, service_cost, created_at FROM services WHERE YEAR(created_at) = YEAR(now())');

        } else if($request->input('pdf') == 'custom') {
            $start = $request->input('startdate');
            $end = $request->input('enddate');

            $serv = DB::select("SELECT srf_no, brand, warranty, description, STATUS, service_cost, created_at  from services where created_at BETWEEN '$start' AND '$end'");
            
        }

        if(sizeof($serv)) {
            $pdf = PDF::loadView('client_module.reportdownload', compact('serv', 'type'));
            return $pdf->download('service_'.date('Y-m-d').'.pdf');
       } else {
           return redirect()->route('reports')->with('noreport', 'zero');
       }

    }

}
