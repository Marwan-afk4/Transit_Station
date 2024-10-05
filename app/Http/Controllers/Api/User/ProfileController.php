<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        return response()->json(['success' => $user]);
    }

    public function editprofile(Request $request)
{
    $user_id = $request->user()->id;
    $user = User::findOrFail($user_id);
    $updateprofile = $request->only(['name', 'email', 'phone','image']);
    $user->name = $updateprofile['name'] ?? $user->name;
    $user->email = $updateprofile['email'] ?? $user->email;
    $user->phone = $updateprofile['phone'] ?? $user->phone;
    $user->image = $updateprofile['image'] ?? $user->image;
    $user->save();
    return response()->json(['success' => $user]);
}
}
