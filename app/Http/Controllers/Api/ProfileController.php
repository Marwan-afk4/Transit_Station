<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $user->image = $user->image ? url('storage/' . $user->image) : null; // Construct full URL
        return response()->json(['success' => $user]);
    }

}
