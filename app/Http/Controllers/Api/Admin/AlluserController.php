<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AlluserController extends Controller
{

    protected $updateuser=['name','email','phone','image','offer_id','start_date','end_date','amount','status'];
    public function usersubscription(Request $request)
    {
        $currentDate = Carbon::now();

        $userSubscriptions = Subscription::with(['offer:id,offer_name', 'user:id,name,email'])->get()->map(function ($subscription) use ($currentDate) {
            // Check if subscription has expired
            if ($subscription->end_date && $currentDate->greaterThan($subscription->end_date) && $subscription->status == 1) {
                $subscription->status = 0;
                $subscription->save();
            }

            return [
                'id' => $subscription->user->id,
                'user_name' => $subscription->user->name,
                'user_email' => $subscription->user->email,
                'offer_name' => $subscription->offer->offer_name ?? '',
                'start_date' => $subscription->start_date,
                'end_date' => $subscription->end_date,
                'amount' => $subscription->amount,
                'status' => $subscription->status
            ];
        });

        $data = [
            'users' => $userSubscriptions,
        ];

        return response()->json($data);
    }

    public function adduser(Request $request){

        $validate=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
            'phone'=>'required|unique:users',
            'role'=>'nullable|in:user,driver',
            'image'=>'nullable|string'
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
        $user->subscription()->create(['offer_id' => $request->offer_id,
        'start_date'=>$request->start_date,
        'end_date'=>$request->end_date]);
        return response()->json(['message' => 'User added successfully']);
    }

    public function updateuser(Request $request, $id){
        $user=User::find($id);
        $user->update($request->only($this->updateuser));
        return response()->json(['message'=>'user updated successfully']);
    }

    public function deleteuser(Request $request, $id){
        $user=User::find($id);
        $user->delete();
        return response()->json(['message'=>'user deleted successfully']);
    }
}

