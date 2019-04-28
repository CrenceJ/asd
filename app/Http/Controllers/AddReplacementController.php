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

class AddReplacementController extends Controller
{

	public function index()
    {
        $currentUser = Helper::staticInfo();
        return view('Admin.addreplacement',compact('currentUser'));
    }

    public function store(Request $request){

		$validator = Validator::make($request->all(), [
            // 'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4090',
			'srf_no'=> 'required',
			'credit_no' => 'required',
			'item' => 'required',
			'brand' => 'required',
			'description' => 'required',
			'price' => 'required',
			'supplier' => 'required',
			'date_recieved' => 'required',
			'quantity' => 'required',
		]);

		if ($validator->fails()) {
			Session::flash('error', $validator->messages()->first());
			return redirect()->back()->withInput();
		}

		date_default_timezone_set('Asia/Manila');
		$replace = new ReplaceModel;
		$replace->srf_no = $request->input('srf');
		$replace->credit_no = $request->input('credit');
		$replace->item = $request->input('item');
		$replace->brand = $request->input('brand');
		$replace->description = $request->input('description');
		$replace->price = $request->input('cost');
		$replace->supplier = $request->input('supplier');
		$replace->date_recieved = $request->input('date');
		$replace->quantity = $request->input('quantity');

		$replace->save();
		return redirect()->back()->with('success','Added to replacement successfully!')->withInput();
	}}
