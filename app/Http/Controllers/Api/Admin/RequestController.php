<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function requestHistory()
    {
        $data = ModelsRequest::
        with(['user.subscription.offer','location'])
        ->get();
        return response()->json($data);
    }
}
