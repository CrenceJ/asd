<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;
class RegistrationController extends Controller
{
	public function store(Request $request){
		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');
		$username = $request->input('username');
		$password = $request->input('password');

		$data = array('first_name' => $first_name, 'last_name' => $last_name, 'username' => $username,'password'=>Hash::make($password));

		DB::table('users')->insert($data);
		echo "Success";

	}

}