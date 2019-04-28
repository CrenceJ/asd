<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use App\InventoryModel;
use Helper;
use Carbon\Carbon;
use DB;
class InventoryAddController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = Helper::staticInfo();
        return view('Admin.adminAddInventory',compact('currentUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
                 $validator = Validator::make($request->all(), [
            // 'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4090',
            'item'=> 'required',
            'brand' => 'required',
            'model' => 'required',
            'description' => 'required',
            'serial' => 'required',
            'cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'supplier' => 'required',
            'date' => 'required',
            

        ]);

            if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
       }

        date_default_timezone_set('Asia/Manila');
        $inventory = new InventoryModel;
        $inventory->inventory_item = $request->input('item');
        $inventory->inventory_brand = $request->input('brand');
        $inventory->inventory_model = $request->input('model');
        $inventory->inventory_description = $request->input('description');
        $inventory->inventory_serial_no = $request->input('serial');
        $inventory->cost = $request->input('cost');
        $inventory->inventory_supplier = $request->input('supplier');
        $inventory->date_received = $request->input('date');
        $inventory->save();
        return redirect()->back()->with('success','Added to inventory successfully!')->withInput();
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
