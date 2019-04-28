<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;
class ServiceEngineerProfileController extends Controller
{
    //
    public function index()
    {
        $detail = DB::table('users')
        ->select('*', DB::raw('DATE_FORMAT(created_at, "%b %d, %Y") as join_date'), DB::raw('DATE_FORMAT(last_login, "%b %d, %Y") as last'),
                    DB::raw('DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), birthdate)), "%Y")+0 as age'))
        ->where('user_id', '=', Auth::user()->user_id)
        ->get();

        return view('client_module.profile', compact('detail'));
    }

    public function edit(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $newUsername = $request->input('uname');
        $newFirstName = $request->input('fname');
        $newLastName = $request->input('lname');
        $newBday = $request->input('bday');

        User::where('user_id', '=', Auth::user()->user_id)
                ->update([
                    'username' => $newUsername,
                    'first_name' => $newFirstName,
                    'last_name' => $newLastName,
                    'birthdate' => $newBday
                ]);
        
        //img
        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('img\uploads\avatars/' . $filename ) );
            $user = Auth::user();
            $user->profile_pic = $filename;
            $user->save();
        }

        return redirect('/profile');
    }
}
