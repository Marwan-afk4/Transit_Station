<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class HomescreenController extends Controller
{

    public function showrequests(Request $request){
        $requests = ModelsRequest::with('driver' )
        ->where('driver_id', $request->user()->id)
        ->where('status','current')
        ->get();
        $data=[
            'requests'=>$requests->map(function($request){
                return [
                    'id'=>$request->id,
                    'car_id'=>$request->car_id ?? 'N/A',
                    'car_name' => $request->car->name ?? 'N/A',
                    'car_image' => $request->car->car_image ?? 'N/A',
                    'car_number' => $request->car->car_number ?? 'N/A',
                    'user_id'=>$request->user_id ?? 'N/A',
                    'user_name' => $request->user->name ?? 'N/A',
                    'user_phone' => $request->user->phone ?? 'N/A',
                    'user_image' => $request->user->image ?? 'N/A',
                    'location_id' => $request->location_id ?? 'N/A',
                    'location_name' => $request->location->pick_up_address ?? 'N/A',
                    'request_time' => $request->request_time,
                    'pick_up_date' => $request->pick_up_date,
                    'return_time' => $request->return_time,
                    'status' => $request->status,
                    'driver' => [
                        'id' => $request->driver->id,
                        'name' => $request->driver->name,
                        'email' => $request->driver->email,
                        'phone' => $request->driver->phone,
                    ],
                ];
            })
        ];
        return response()->json($data);
    }
}
