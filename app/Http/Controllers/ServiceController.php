<?php

namespace App\Http\Controllers;
use App\ServicesModel;
use App\ClientsModel;
use App\InventoryModel;
use App\SalesModel;
use App\OrdersModel;
use App\OrderDetailsModel;
use Illuminate\Http\Request;
use Helper;
use Auth;
use DB;
use Carbon\Carbon;

class ServiceController extends Controller {
    
    private $serviceModel;

    public function __construct(ServicesModel $serviceModel)
    {
        $this->serviceModel = $serviceModel;
       date_default_timezone_set('Asia/Manila'); 
    }

    public function index()
    {
        $currentUser = Helper::staticInfo();
        return view('client_module.services', compact('currentUser'));
    }

    public function myServices()
    { 
       $myServices = $this->serviceModel::with('inventory', 'client')
        ->where('user_id', '=', Auth::user()->user_id)
        ->where('status', '!=','Done')
        ->orderby('service_id', 'DESC')
        ->get();

        $currentUser = Helper::staticInfo();
        $inventories = InventoryModel::where('inventory_status', '=', 'Available')->get();
        return view('client_module.myservices', compact('myServices', 'inventories', 'currentUser'));
    }

    public function allServices()
    {
        $currentUser = Helper::staticInfo();
        
        $allServices = $this->serviceModel::with('client', 'user', 'inventory')
        ->orderby('service_id', 'DESC')
        ->get();

        return view('client_module.allservices', compact('currentUser', 'allServices'));
    }
    
    public function addServices()
    {
        $currentUser = Helper::staticInfo();
        return view('client_module.addservices', compact('currentUser'));
    }

    public function renderForms()
    {
        $currentUser = Helper::staticInfo();
        $formType = $_GET['type'];
        return view('client_module.serviceform', compact('currentUser', 'formType'));
    }

    public function saveForms(Request $request)
    {   
        $currentUser = Helper::staticInfo();
        $desc = $request->input('sira');
        $desc2 = '';
        for($i = 0; $i < sizeof($desc); $i++) {
            $desc2 .= $desc[$i] . ', ';
        }
        $desc3 = substr_replace($desc2 ,"",-2);

        $brands = array('canon', 'acer', 'others');
        $type = strtolower($request->input('hidden_brand'));
        
        if($request->input('brand_type') == null) {
            $brando = strtolower($request->input('hidden_brand'));
        } else {
            $brando = $request->input('brand_type');
        }

        if(in_array($type, $brands)) {
            $service = new ServicesModel;
            $clients = new ClientsModel;

            $clients->first_name = $request->input('fname');
            $clients->last_name = $request->input('lname');
            $clients->contact_no = $request->input('cp_no');
            $clients->email = $request->input('email');
            $clients->address = $request->input('addr');
            $clients->landline_no = $request->input('landline');
            $clients->created_at = Carbon::now();
            $clients->save();


            $lastInsertClient =  ClientsModel::orderby('client_id', 'desc')->first()->client_id;
            $service->srf_no = $request->input('srf');
            $service->brand = ucfirst($brando);
            $service->warranty = 'Not Warranted';
            $service->description = $desc3;
            $service->status = "Waiting";
            $service->service_cost = $request->input('servfee');
            $service->date_finished = "N/A";
            $service->user_id = Auth::user()->user_id;
            $service->client_id = $lastInsertClient;
            $service->serial = $request->input('serial');
            $service->case_id = $request->input('case_id');
            $service->accessories = $request->input('acc');
            $service->unit_password = $request->input('password');
            $service->repair_model = $request->input('model');
            $service->created_at = Carbon::now();
            $service->save();
            
            $success = true;
            return view('client_module.addservices', compact('currentUser', 'success'));

        } else {
            $success = false;
            return view('client_module.addservices', compact('currentUser', 'success'));
        }
    }

    public function updateStatus(Request $request) //para di na maulit yung Request $request, pwede i dependency injection
    { 

        $fname = $request->input('fnameUpdate');
        $lname = $request->input('lnameUpdate');
        $status = $request->input('serviceStatus');
        $clientId = $request->input('name_id');
        $servId = $request->input('serv_id');
        


        DB::table('clients')->where('client_id', '=', $clientId)
        ->update([
            'first_name' => $fname,
            'last_name' => $lname,
            'updated_at' => Carbon::now()
        ]);

        DB::table('services')->where('service_id', '=', $servId)
        ->update([
            'status' => $status,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('myservices');
    }

    public function updateItem(Request $request) 
    {  
        $orders = new OrdersModel;
        $client = DB::table('clients')->select('client_id')->orderby('client_id', 'desc')->limit('1')->get();
        foreach($client as $c){
            $lastClient = $c->client_id;
        }

        $totalCost = 0;
        $servId = $request->input('service-id');
        $inventory = array_unique($request->input('iteminventory'));
        $owner = $request->input('client-id');
        $srf = $request->input('srf-no');

        $inventory = array_unique($request->input('iteminventory'));
        //add order/s for service
        $orders->or_number = $request->input('ornum');
        $orders->client_id = $owner;
        $orders->order_type = 'Service Parts';
        $orders->order_status = 'Unpaid';
        $orders->created_at = Carbon::now();
        $orders->updated_at = Carbon::now();
        $orders->save();

        DB::table('services')->where('service_id', '=', $servId)
        ->update([
            'order_id' => $order_id = $orders->order_id
        ]);

        for($i = 0; $i < sizeof($inventory); $i++) {
            $order_details = new OrderDetailsModel;
            $order_details->order_id = $orders->order_id;
            $order_details->inventory_id = $inventory[$i];
            $order_details->created_at = Carbon::now();
            $order_details->updated_at = Carbon::now();
            $order_details->save();

            DB::table('inventory')->where('inventory_id', '=', $inventory[$i])
            ->update([
                'inventory_owner_id' => $lastClient,
                'inventory_status' => 'Sold'
            ]);
        }

        return redirect()->route('myservices')->with('good', 'asd');

    }

    public function itemsCostAjax(Request $request)
    {
        $client_id = $request->client_id;
        $cost = 0;
        $inventoryList = array();

        $inventory = DB::table('inventory')->where('inventory_owner_id', '=', $client_id)->get();
        $inventoryCount = count($inventory);

        if($inventoryCount > 0){

            foreach($inventory as $inv) {
                $cost += $inv->cost;
                array_push($inventoryList, $inv->inventory_item);
            }
             return ['cost' => $cost, 'inventory' => $inventoryList];
        } else {
            return ['cost' => 0, 'inventory' => $inventoryList];
        }
 

    }
}

