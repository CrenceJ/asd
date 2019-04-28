<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;
use DB;


class LoginController extends Controller
{
    //
    public function index()
    {
        return view('client_module.login');
    }
    public function doLogout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function doLogin()
    { 
        date_default_timezone_set('Asia/Manila');

        $rules = array(
            'username'    => 'required', 
            'password' => 'required|min:3'
        );

        $validator = \Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return \Redirect::to('/')
                ->withErrors($validator)
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            $userdata = array(
                'username'     => Input::get('username'),
                'password'  => Input::get('password')
            );

            if (Auth::attempt($userdata)) {
                DB::table("users")
                    ->update(
                        ['last_login' => Carbon::now(),
                         'updated_at'=> Carbon::now()
                        ]
                    );
                
                if(Auth::user()->type == 'service engineer')  {

                    return \Redirect::to('/service_engineer');

                } else if(Auth::user()->type == 'Administrator') {
                    
                    return \Redirect::to('/admin_login');
                }

            } else {        
                // validation not successful, send back to form 
                return \Redirect::to('/');
            }

        }
    }
}
