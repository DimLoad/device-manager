<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Device;
use App\User;
use DB;

class DevicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = Device::orderBy('name', 'desc')->paginate(10);

        // TO DO - find out how to do this with Eloquent
        // map owner's name to each device to populate select options
        foreach ( $devices as $device) {
            $device['ownerName'] = $device->user['name'];
        }

        return view('devices.index')->with('devices', $devices);
    }


    public function getUserDevices()
    {
        $user = User::find(Input::get('userId'));
        $devices = Device::all();
 
        // TO DO - find out how to do this with Eloquent
        // map owner's name to each device to populate select options
        foreach ( $devices as $device) {
            $device['ownerName'] = $device->user['name'];
        }
   
        return ['user' => $user, 'userDevices' => $user->devices, 'devices' => $devices ];
    }

    public function assignDevice()
    {   
        if ( array_key_exists('userId', $_GET) && array_key_exists('deviceId', $_GET) ) {
            $update = DB::table('devices')
                ->where('id', Input::get('deviceId'))
                ->update(['user_id' => Input::get('userId')]);

                if ($update) {
                    $result = 1;
                } else {
                    $result = 0;
                }          
        } else {
            $result = 1;
        }

        return $result ? Device::find(Input::get('deviceId')) : 0;
    }

    public function deallocateDevice()
    {
        if (array_key_exists('deviceId', $_GET)) {
            $update = DB::table('devices')
                ->where('id', Input::get('deviceId'))
                ->update(['user_id' => null]);

                if ($update) {
                    $result = 1;
                } else {
                    $result = 0;
                }          
        } else {
            $result = 1;
        }

        return $result;        
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
        //
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
        //
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
