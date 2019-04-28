<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use DateTime;
use Carbon\Carbon;
use Session;
use Auth;
use DB;
class ResetPassword extends Controller
{
public function resetPassword(Request $request){

        if (!(Hash::check($request->get('current'), Auth::user()->password))) {
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current'), $request->get('new')) == 0){
            return redirect('/')->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current' => 'required',
            'new' => 'required|string|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->get('new'));
        $user->save();

        return redirect('Admin.successpage')->back()->with("success","Password changed successfully !");

    }
}