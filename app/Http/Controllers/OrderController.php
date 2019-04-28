<?php

namespace App\Http\Controllers;
use App\InventoryModel;
use App\ServicesModel;
use App\ClientsModel;
use App\OrdersModel;
use App\OrderDetailsModel;
use App\SalesModel;

use Auth;
use Carbon\Carbon;
use DB;
use Helper;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $inventory;
    private $order;

    public function __construct(InventoryModel $inventory, OrdersModel $order)
    {
        $this->inventory=$inventory;
        $this->order=$order;
        date_default_timezone_set('Asia/Manila'); 
    }
    // show the forms
    public function purchaseIndex()
    {   
        $currentUser = Helper::staticInfo();
        return view('client_module.purchase_parts', compact('currentUser'));
    }


    public function customIndex()
    {
        $currentUser = Helper::staticInfo();
        $inventories = $this->inventoryByCategory();

        return view('client_module.customize', compact('currentUser', 'inventories'));
    }

    //display pc build summary
    public function viewSummary(Request $request)
    {
        // return $request;
        //store client info in array
        $client = array($request->input('fname'), $request->input('lname'), $request->input('contact'), $request->input('category'), $request->input('or_no'));

        //get id's and costs get item names for display
        $order['cpu'] = $request->input('cpu') == null ? array('NONE') : $request->input('cpu');
        $order['motherboard'] = $request->input('motherboard') == null ? array('NONE') : $request->input('motherboard');
        $order['gpu'] = $request->input('gpu') == null ? array('NONE') : $request->input('gpu');
        $order['ram'] = $request->input('ram') == null ? array('NONE') : $request->input('ram');
        $order['hdd'] = $request->input('hdd') == null ? array('NONE') : $request->input('hdd');
        $order['os'] = $request->input('os') == null ? array('NONE') : $request->input('os');
        $order['ms'] = $request->input('ms') == null ? array('NONE') : $request->input('ms');
        $order['power'] = $request->input('power') == null ? array('NONE') : $request->input('power');
        $order['cool'] = $request->input('cool') == null ? array('NONE') : $request->input('cool');
        $order['fan'] = $request->input('fan') == null ? array('NONE') : $request->input('fan');
        $order['monitor'] = $request->input('monitor') == null ? array('NONE') : $request->input('monitor');
        $order['mouse'] = $request->input('mouse') == null ? array('NONE') : $request->input('mouse');
        $order['keyboard'] = $request->input('keyboard') == null ? array('NONE') : $request->input('keyboard');
        $order['headset'] = $request->input('headset') == null ? array('NONE') : $request->input('headset');

        //manipulate data
        $inventoryId = array();
        $totalCost = 0;

        foreach($order as $index => $key) {
            $data = $this->getIds($index, $order);
            $totalCost+= $data['totalCost'];
            foreach($data['inventoryId'] as $inv) {
                array_push($inventoryId, $inv);
            }
        }

        $currentUser = Helper::staticInfo();
        return view('client_module.order_summary_pc', compact('currentUser', 'order', 'client', 'totalCost', 'inventoryId'));
    }

    public function getIds($index, $orderArray)
    { 
        $totalCost = 0;
        $inventoryId = array();
        $data['inventoryId'] = array();

        foreach($orderArray[$index] as $c) {
            if ((strpos($c, "->")) !== FALSE) {
                $id = substr($c, 0, strpos($c, '->'));
                array_push($inventoryId, $id);
                $totalCost += (int)substr($c, strpos($c, "~~")+2); 
            }
        }
        $data['totalCost'] = $totalCost;
        $data['inventoryId'] = $inventoryId;

        return $data;
    }


    //create orders
    // MANIPULATE THE ARRAY DONT DELETE!!!!
    //get first number
    // $data = '3->Asdas~~1500';
    // $id='';
    // $item='';
    // $itemtemp='';
    // $cost='';

    // if ((strpos($data, "->")) !== FALSE) {  //if exist -> gawin. else retain none;
    //     $id = substr($data, 0, strpos($data, '->'));
    //     $itemtemp = substr($data, strpos($data, "->")+2); 
    //     $item = substr($itemtemp, 0, strpos($itemtemp, '~~'));
    //     $cost = substr($data, strpos($data, "~~")+2); 
    // }


    // echo $id.' '.$item.' '.$cost; //magic!!!

    public function createOrder(Request $request)
    {
        $ids = array();
        $client = new ClientsModel;

        // 1. Save Client
        $client->first_name = $request->input('fname');
        $client->last_name = $request->input('lname');
        $client->contact_no = $request->input('contact');
        $client->email = 'N/A';
        $client->address = 'N/A';
        $client->landline_no = 'N/A';
        $client->created_at = Carbon::now();
        $client->updated_at = Carbon::now();
        $client->save();
        
        // 2. Get latest client id and store
        $latestClientId = $client->client_id;

        // 3. update all inventory to sold and add owner to it using client id, if pending skip
        if(!$request->input('category') == 'Pending'){
            $ids = $request->input('inventoryid');
            if($all = count($ids)) {
                for($i=0; $i<$all; $i++) {
                    InventoryModel::where('inventory_id', $ids[$i])
                    ->update([
                        'inventory_status' => 'Sold',
                        'inventory_owner_id' => $latestClientId,
                        'updated_at' => Carbon::now()
                    ]);
                }
            } else {
                return '<script> alert("ERROR NO ORDERS!"); </script>';
            }
        }

        // 4. add order table or_number, client_id, type, timestamps boom magic may order na
        $order = new OrdersModel;
        $order->or_number = $request->input('or_no');
        $order->client_id = $latestClientId;
        if($request->input('category') == 'Pending'){
            $order->order_status = 'Pending';
            $order->order_type = 'REQUEST';
        }else {
            $order->order_type = strtoupper($request->input('category'));
            $order->order_status = 'Unpaid';
        }
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();
        $order->save();

        $latestOrderId = $order->order_id;

        // 5. add order_details and add inventory id there don't forget the FK order.order_id
        if($request->input('category') == 'Pending'){
               $this->pendingitems($request, $latestOrderId);
        }else{

            for($i=0; $i<count($ids); $i++) {
                $order_detail = new OrderDetailsModel;
                $order_detail->order_id =  $latestOrderId;
                $order_detail->inventory_id = $ids[$i];
                $order_detail->created_at = Carbon::now();
                $order_detail->updated_at = Carbon::now();
                $order_detail->save();
            }
        }

        
        $currentUser = Helper::staticInfo();
        $success = true;
        return view('client_module.purchase_parts', compact('currentUser', 'success'));
    }

    public function pendingitems($request, $latestOrderId)
    {
        $order['cpu'] = $request->input('cpu') == null ? array('NONE') : $request->input('cpu');
        $order['motherboard'] = $request->input('motherboard') == null ? array('NONE') : $request->input('motherboard');
        $order['gpu'] = $request->input('gpu') == null ? array('NONE') : $request->input('gpu');
        $order['ram'] = $request->input('ram') == null ? array('NONE') : $request->input('ram');
        $order['hdd'] = $request->input('hdd') == null ? array('NONE') : $request->input('hdd');
        $order['os'] = $request->input('os') == null ? array('NONE') : $request->input('os');
        $order['ms'] = $request->input('ms') == null ? array('NONE') : $request->input('ms');
        $order['power'] = $request->input('power') == null ? array('NONE') : $request->input('power');
        $order['cool'] = $request->input('cool') == null ? array('NONE') : $request->input('cool');
        $order['fan'] = $request->input('fan') == null ? array('NONE') : $request->input('fan');
        $order['monitor'] = $request->input('monitor') == null ? array('NONE') : $request->input('monitor');
        $order['mouse'] = $request->input('mouse') == null ? array('NONE') : $request->input('mouse');
        $order['keyboard'] = $request->input('keyboard') == null ? array('NONE') : $request->input('keyboard');
        $order['headset'] = $request->input('headset') == null ? array('NONE') : $request->input('headset');

        foreach($order['cpu'] as $c) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'CPU_'.$c;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['motherboard'] as $m) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'MOTHERBOARD_'.$m;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['ram'] as $r) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'RAM_'.$r;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['gpu'] as $g) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'GPU_'.$g;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['hdd'] as $h) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'HDD_'.$h;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['os'] as $o) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'OS_'.$o;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['ms'] as $ms) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'MS_'.$ms;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['power'] as $p) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'POWER_'.$p;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['cool'] as $cool) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'COOL_'.$cool;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['fan'] as $fan) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'FAN_'.$fan;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['monitor'] as $moni) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'MONITOR_'.$moni;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['mouse'] as $mouse) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'MOUSE_'.$mouse;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['keyboard'] as $key) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'KEYBOARD_'.$key;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        foreach($order['headset'] as $head) {
            $order_detail = new OrderDetailsModel;
            $order_detail->order_id =  $latestOrderId;
            $order_detail->inventory_id = 0;
            $order_detail->pending_item = 'HEADSET_'.$head;
            $order_detail->created_at = Carbon::now();
            $order_detail->updated_at = Carbon::now();
            $order_detail->save();
        }

        return;
        
    }

    public function inventoryByCategory()
    {
        $inventories['CPU'] = $this->inventory::where('inventory_type', '=', 'CPU')->where('inventory_status', '=', 'Available')->get();
        $inventories['HDD'] = $this->inventory::where('inventory_type', '=', 'Hard Drive/SSD')->where('inventory_status', '=', 'Available')->get();
        $inventories['Motherboard'] = $this->inventory::where('inventory_type', '=', 'Motherboard')->where('inventory_status', '=', 'Available')->get();
        $inventories['RAM'] = $this->inventory::where('inventory_type', '=', 'RAM')->where('inventory_status', '=', 'Available')->get();
        $inventories['GPU'] = $this->inventory::where('inventory_type', '=', 'GPU')->where('inventory_status', '=', 'Available')->get();
        $inventories['OS'] = $this->inventory::where('inventory_type', '=', 'OS')->where('inventory_status', '=', 'Available')->get();
        $inventories['MS'] = $this->inventory::where('inventory_type', '=', 'MS')->where('inventory_status', '=', 'Available')->get();
        $inventories['Power'] = $this->inventory::where('inventory_type', '=', 'Power Supply')->where('inventory_status', '=', 'Available')->get();
        $inventories['Cool'] = $this->inventory::where('inventory_type', '=', 'Processor Cooling')->where('inventory_status', '=', 'Available')->get();
        $inventories['Fan'] = $this->inventory::where('inventory_type', '=', 'Extra Case Fan')->where('inventory_status', '=', 'Available')->get();
        $inventories['Monitor'] = $this->inventory::where('inventory_type', '=', 'Monitor')->where('inventory_status', '=', 'Available')->get();
        $inventories['Mouse'] = $this->inventory::where('inventory_type', '=', 'Mouse')->where('inventory_status', '=', 'Available')->get();
        $inventories['Keyboard'] = $this->inventory::where('inventory_type', '=', 'Keyboard')->where('inventory_status', '=', 'Available')->get();
        $inventories['Headset'] = $this->inventory::where('inventory_type', '=', 'Headset')->where('inventory_status', '=', 'Available')->get();

        return $inventories;
    }

    public function viewOrders()
    {
        $currentUser = Helper::staticInfo();
        $orders = $this->order::with('clients', 'details')
        ->where('orders.order_status', '!=', 'Pending')
        ->orderby('orders.created_at', 'DESC')
        ->get();

        $orderDetails = DB::select("SELECT cost, inventory_item, pending_item, order_id, i.inventory_id FROM inventory i JOIN order_details o ON  i.inventory_id = o.inventory_id");
        return view('client_module.orders', compact('currentUser', 'orders', 'orderDetails'));
    }

    public function viewOrdersReq()
    {
        $currentUser = Helper::staticInfo();
        $orders = $this->order::with('clients', 'details')
        ->where('orders.order_status', '=', 'Pending')
        ->orderby('orders.created_at', 'DESC')
        ->get();

        return view('client_module.orders_req', compact('currentUser', 'orders'));
        
    }
    
    public function payOrder(Request $request)
    {
        $sales = new SalesModel;
        $orders = new OrdersModel;
        $totalCost = 0;
        $inventories = $request->input('inventory');
        $order_id = $request->input('order_id');
        $identitifer = $request->input('identifier');

        for($i=0; $i<sizeof($inventories); $i++) {
            $temp = DB::table('inventory')->select('cost')->where('inventory_id', '=', $inventories[$i])->get();
            foreach($temp as $cost) {
                $totalCost += $cost->cost;
            }
        }
        $sales->order_id = $order_id;
        if($identitifer == null) {
            $sales->cost = $totalCost;
        }else{
            $sales->cost = $request->input('cost');
        }
        $sales->user_id = Auth::user()->user_id;
        $sales->save();

        DB::table('orders')->where('order_id', '=', $order_id)
        ->update([
            'order_status' => 'Paid'
        ]);

        return redirect()->route('sales')->with('good', 'good');
    }
}
