<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServicesModel;
use App\ClientsModel;
use App\InventoryModel;
use Helper;
use Auth;
use DB;
use Carbon\Carbon;

class NotificationController extends Controller
{
    //
    private $service;

    public function __construct(ServicesModel $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $doneServices = $this->service::with('inventory', 'client')
        ->where('user_id', '=', Auth::user()->user_id)
        ->where('status', '=','Done')
        ->orwhere('status', '=', 'Back Job')
        ->orderby('service_id', 'DESC')
        ->get();

        // return $doneServices;
        $currentUser = Helper::staticInfo();
        return view('client_module.notifications', compact('currentUser', 'doneServices'));
    }

    public function claimDevice(Request $request)
    {
        $srfClaim = $request->input('srfClaim');

        $this->service::where('srf_no', $srfClaim)
            ->update(
                [
                    'status' => 'Claimed',
                    'updated_at' => Carbon::now(),
                    'srf_no' => $srfClaim
                ]
                );
        return redirect()->route('notifications');
    }
}
