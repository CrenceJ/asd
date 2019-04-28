<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use DateTime;
use Carbon\Carbon;
use Session;
use DB;
class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            // 'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:4090',
            'first_name'=> 'required|regex:/^[a-zA-Z ]+$/',
            'last_name' => 'required|regex:/^[a-zA-Z ]+$/',
            'gender' => 'required',
            'usertype' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|confirmed|min:6',
            'mobile' => 'required|regex:/(09)[0-9]{9}/',
            'birthday' => 'required|before:18 years ago'

        ]);

            if ($validator->fails()) {
            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
       }

        date_default_timezone_set('Asia/Manila');
        $users = new User;
      if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('img\uploads\avatars/' . $filename ) );
            $users = Auth::user();
            $users->profile_pic = $filename;
            $users->save();
        }
        $users->username = $request->input('username');
        $users->first_name = $request->input('first_name');
        $users->last_name = $request->input('last_name');
        $users->email = $request->input('email');
        $users->birthdate = $request->input('birthday');
        $users->contact = $request->input('mobile');
        $users->gender = $request->input('gender');
        $users->type = $request->input('usertype');
        $users-> fill(['password' => Hash::make($request['password']),]);
        $users->save();
        return redirect('/settings')->with('success','Registration created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
