<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class UsersubsController extends Controller
{
    protected $updateRequest = ['name', 'email', 'password', 'phone', 'role', 'image',];
    protected $subscriptionRequest = ['offer_id', 'amount','start_date','end_date','amount'];
    public function usersubscription(Request $request)
    {
        $userSubscriptions = Subscription::with(['offer:id,offer_name', 'user:id,name'])->get()->map(function ($subscription) {
            return [
                'id' => $subscription->user->id,
                'user_name' => $subscription->user->name,
                'offer_name' => $subscription->offer->offer_name,
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

    public function offers(){
        $offers = Offer::all();
        return response()->json($offers);
    }

    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $updateSubscription = $request->only($this->subscriptionRequest);
        $subscriptionUpdate = $user->subscription()->update($updateSubscription); // Update subscription
        return response()->json(['message' => 'User updated successfully'],200);
    }

    public function destroy($id)
    {

        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return response()->json(['message' => 'Subscription deleted successfully']);
    }
}
