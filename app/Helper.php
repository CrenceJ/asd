<?php 
namespace App\Helpers;
use Auth;
use App\ClientsModel;
use DB;
use App\ServicesModel;
use App\InventoryModel;
use Carbon\Carbon;

class Helper {

    public static function staticInfo() 
    {
        $service = new ServicesModel;
        $currentUser['name'] =  Auth::user()->first_name .' '. Auth::user()->last_name;
        $currentUser['uname'] = Auth::user()->username;
        $currentUser['contact'] = Auth::user()->contact;
        $currentUser['email'] = Auth::user()->email;
        $currentUser['fname'] = Auth::user()->first_name;
        $currentUser['lname'] = Auth::user()->last_name;



        $currentUser['profile_pic'] =  Auth::user()->profile_pic;
        $currentUser['type'] = ucfirst(Auth::user()->type);
        

        $notifCount = $service::with('inventory', 'client')
        ->where('user_id', '=', Auth::user()->user_id)
        ->where('status', '=','Done')
        ->orderby('service_id', 'DESC')
        ->get();

        $currentUser['notif'] = $notifCount->count();

        return $currentUser;
    }

}