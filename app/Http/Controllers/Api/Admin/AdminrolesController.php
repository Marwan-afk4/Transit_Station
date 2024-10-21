<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminPosition;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminrolesController extends Controller
{

    protected $admin=['name','email','phone','image','password','admin_position_id','user_code'];

    protected $updateAdminPosition = [
        'name' => 'required|string|unique:admin_positions,name',
        'role_name' => 'required|array',
        'role_name.*' => 'string'
    ];


    protected $updateadmin=['name','email','phone','image','password','admin_position_id','user_code'];
    public function addadmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users,phone',
            'role' => 'nullable|in:admin',
            'image'=>'nullable|string',
            'admin_position_id'=>'nullable|exists:admin_positions,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $validator= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'image' => $request->image,
            'role' => $request->role ?? 'admin',
            'admin_position_id' => $request->admin_position_id ?? null,
        ]);

        return response()->json(['admin added successfully'=>$validator]);
    }

    public function updateadmin(Request $request, $id){

        $validator = Validator::make($request->all(), [$this->updateadmin]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $admin = User::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $request->image,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
            'admin_position_id' => $request->admin_position_id ?? null,
            'user_code'=>$request->user_code ?? $admin->user_code
        ]);
        return response()->json(['message' => 'Admin updated successfully']);
    }

    public function deleteadmin($id){

        $admin = User::find($id);
        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404);
        }
        $admin->delete();
        return response()->json(['message' => 'Admin deleted successfully']);
    }



    public function addAdminPosition(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|unique:admin_positions,name',
            'role_name' => 'required|array',
            'role_name.*' => 'exists:roles,role_name',
        ]);

        // Create the admin position
        $adminposition = AdminPosition::create([
            'name' => $validated['name'],
        ]);

        // Assign all roles to the newly created admin position
        foreach ($validated['role_name'] as $role_name) {
            Role::create([
                'role_name' => $role_name,
                'admin_position_id' => $adminposition->id,
            ]);
        }

        // Now return the response after all roles have been assigned
        return response()->json([
            'message' => 'Admin position and roles added successfully',
            'data' => $adminposition->load('role'),
        ]);
    }

    public function updateAdminPosition(Request $request, $id)
{
    $validated = $request->validate($this->updateAdminPosition);

    $adminposition = AdminPosition::find($id);
    if (!$adminposition) {
        return response()->json(['message' => 'Admin position not found'], 404);
    }

    $adminposition->update([
        'name' => $validated['name'],
    ]);

    $adminposition->role()->delete();

    foreach ($validated['role_name'] as $role_name) {
        Role::create([
            'role_name' => $role_name,
            'admin_position_id' => $adminposition->id,
        ]);
    }

    return response()->json(['message' => 'Admin position and roles updated successfully']);
}

    public function deleteAdminPosition($id)
    {
        $adminposition = AdminPosition::find($id);
        if (!$adminposition) {
            return response()->json(['message' => 'Admin position not found'], 404);
        }
        $adminposition->delete();
        return response()->json(['message' => 'Admin position deleted successfully']);
    }


    public function showadminposition(Request $request){
        $roles = ['parkings','locations','offers','drivers','subscriptions','requests','plans','users','revenues','expences'];
        $admin_positions=AdminPosition::with('role')->get();
        $admins=User::where('role','admin')
        ->with('admin_position')
        ->get();
        $data=[
            'admin_positions'=>$admin_positions,
            'roles'=>$roles,
            'admins'=>$admins
        ];

        return response()->json($data);

    }




}

