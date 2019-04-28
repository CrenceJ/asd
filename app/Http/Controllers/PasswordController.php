<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Hash;
class PasswordController extends Controller
{
    //
    public function changer(Request $request){

    	$old = $request->input('oldpw');
    	$new = $request->input('newpw');
    	$conf = $request->input('confnewpw');

    	$myold = DB::table('users')
      ->select('password', 'type')
      ->where('user_id', '=', Auth::id())
      ->first();

      if(Hash::check($old, $myold->password) && ($new == $conf)){
         
         $cryptnew = bcrypt($new);

         DB::table('users')
         ->where('user_id', '=', Auth::id())
         ->update([
            "password" => $cryptnew,
            "updated_at" => Carbon::now()
            ]);

         Auth::logout();
         return redirect('/');

     }else{

        if($myold->type == 'service engineer'){

        return redirect('/profile')->with('mismatch', 'Password mismatch');

        }elseif($myold->type == 'Administrator'){

        return redirect('/settings')->with('mismatch', 'Password mismatch');
            

        }
    }


}
}
