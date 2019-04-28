<?php

namespace App\Http\Controllers;
use DB;
use Helper;
use Illuminate\Http\Request;

class announcementController_client extends Controller
{
    public function index() 
    {
        $currentUser = Helper::staticInfo();
        
        $announcements = DB::table('announcement')->select('announce_id','subject', 'content', 'created_at','updated_at')->get();
       
        return view('client_module.announcement', compact('currentUser', 'announcements'));
    }

    public function delete(Request $request)
    {

        DB::table('announcement')->where('announce_id', $request->input('annid'))->delete();
        return redirect()->route('announcement');
        
    }

    }
  