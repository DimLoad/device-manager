<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Device;

class PagesController extends Controller
{
	public function index() {
		$data['title'] = 'Device Allocation';
		
		$data['userSignedIn'] = auth()->user() ?? null;

		$data['users'] = User::all();
				
		return view( 'pages.index',$data);
	}
}
