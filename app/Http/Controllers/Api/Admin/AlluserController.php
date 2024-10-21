<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AlluserController extends Controller
{

    protected $updateprofile=['name','email','phone','image'];

    protected $updateUserCode=['user_code'];

    protected $updateuser=['name','email','phone','image','offer_id','start_date','end_date','amount','status'];
    public function usersubscription(Request $request)
{
    $currentDate = Carbon::now();

    // Get all users with their subscriptions (if any)
    $userSubscriptions = User::with(['subscription.offer:id,offer_name'])->get()->map(function ($user) use ($currentDate) {
        // Get the first subscription (if any)
        $subscription = $user->subscription ? $user->subscription->first() : null;

        // Check if the subscription exists and if it has expired
        if ($subscription && $subscription->end_date && $currentDate->greaterThan($subscription->end_date) && $subscription->status == 1) {
            $subscription->status = 0;
            $subscription->save();
        }

        // Return user data along with subscription details (if it exists)
        return [
            'id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'offer_name' => $subscription ? optional($subscription->offer)->offer_name : 'No Offer',
            'start_date' => $subscription->start_date ?? null,
            'end_date' => $subscription->end_date ?? null,
            'amount' => $subscription->amount ?? null,
            'status' => $subscription->status ?? null,
        ];
    });

    return response()->json(['users' => $userSubscriptions]);
}




    public function adduser(Request $request){

        $validate=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'phone'=>'required|unique:users',
            'role'=>'nullable|in:user',
            'image'=>'nullable|string',
            'offer_id'=>'nullable|exists:offers,id',
            'start_date'=>'nullable|date',
            'end_date'=>'nullable|date',
            'amount'=>'nullable|numeric',
        ]);
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }

        $data=[
            'message'=>'added successfully',
            'data'=>$validate
        ];

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->image = $request->image ??'';
        $user->role = $request->role ??'user';
        $user->save();
        // $user->subscription()->create(['offer_id' => $request->offer_id ]);
        // 'start_date'=>$request->start_date,
        // 'end_date'=>$request->end_date,
        // 'amount'=>$request->amount,]);
        return response()->json(['message' => 'User added successfully']);
    }

    public function updateuser(Request $request, $id)
{
    $user = User::find($id);
    $user->update($request->only($this->updateuser));

    // Check if offer_id, start_date, end_date, or amount is provided in the request
    if ($request->hasAny(['offer_id', 'start_date', 'end_date', 'amount'])) {
        // Find the user's subscription
        $subscription = $user->subscription()->first();

        // Update subscription details
        $subscription->offer_id = $request->offer_id ?? $subscription->offer_id;
        $subscription->start_date = $request->start_date ?? $subscription->start_date;
        $subscription->end_date = $request->end_date ?? $subscription->end_date;
        $subscription->amount = $request->amount ?? $subscription->amount;
        $subscription->save();
    }

    return response()->json(['message' => 'done updated successfully']);
}


    public function deleteuser(Request $request, $id){
        $user=User::find($id);
        $user->delete();
        return response()->json(['message'=>'user deleted successfully']);
    }

    public function adminprofile(Request $request){
        $user = $request->user();
        return response()->json(['data' => $user]);
    }

    public function edirptofileadmin(Request $request){
        $admin_id=$request->user()->id;
        $admin=User::find($admin_id);
        $updateprofile=$request->only(['name','email','phone','image','password']);
        $admin->name=$updateprofile['name'] ?? $admin->name;
        $admin->email=$updateprofile['email'] ?? $admin->email;
        $admin->phone=$updateprofile['phone'] ?? $admin->phone;
        $admin->image=$updateprofile['image'] ?? $admin->image;
        $admin->password=$updateprofile['password'] ?? $admin->password;
        $admin->save();
        return response()->json(['success' => $admin]);
    }

    public function editUserCode(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'user_code' => ['required', 'string', Rule::unique('users', 'user_code')->ignore($id)],
        ]);
        if ($validator->fails()) { // if Validate Make Error Return Message Error
            return response()->json([
                'error' => $validator->errors(),
            ],400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->only($this->updateUserCode));

        return response()->json(['message' => 'User code updated successfully']);
    }
}

