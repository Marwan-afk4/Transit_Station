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
            'requests'=>$requests
        ];
        return response()->json($data);
    }
}
