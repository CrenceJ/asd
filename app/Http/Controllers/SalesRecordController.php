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

class SalesRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = Helper::staticInfo();
        // return DB::select('SELECT o.order_id, o.or_number, CONCAT(c.first_name, " ", c.last_name) AS name, o.order_type, s.cost, s.created_at FROM
        //             clients c INNER JOIN orders o INNER JOIN sales s ON s.order_id = o.order_id AND o.client_id = c.client_id');
        $viewSales = DB::table('orders','sales')
        ->join('clients','clients.client_id','orders.client_id')
        ->join('sales','sales.order_id','orders.order_id')
        ->join('users','users.user_id','sales.user_id')
        ->join('services','services.service_id','orders.order_id')
        ->select('orders.or_number','services.srf_no',\DB::raw('CONCAT(users.first_name," ", users.last_name) AS ServiceEngineer'),'orders.order_type','sales.cost','sales.updated_at','orders.order_status')
        ->get();
        return view('Admin.purchases', compact('currentUser','viewSales'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
