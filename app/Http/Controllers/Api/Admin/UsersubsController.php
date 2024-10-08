<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UsersubsController extends Controller
{
    protected $updateRequest = ['name', 'email', 'password', 'phone', 'role', 'image',];
    protected $subscriptionRequest = ['offer_id', 'amount','start_date','end_date','amount'];

    public function usersubscription(Request $request)
    {
        $currentDate = Carbon::now();

        $userSubscriptions = Subscription::with(['offer:id,offer_name', 'user:id,name'])->get()->map(function ($subscription) use ($currentDate) {
            // Check if subscription has expired
            if ($currentDate->greaterThan($subscription->end_date) && $subscription->status == 1) {
                $subscription->status = 0;
                $subscription->save();
            }

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
        $users= User::all();
        $data=[
            'offers'=>$offers,
            'users'=>$users
        ];

        return response()->json($data);
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

    public function addsubscription(Request $request)
    {
        $subscription = new Subscription();
        $subscription->offer_id = $request->offer_id;
        $subscription->user_id = $request->user_id;
        $subscription->amount = $request->amount;
        $subscription->start_date = $request->start_date;
        $subscription->end_date = $request->end_date;
        $subscription->save();
        return response()->json(['message' => 'Subscription added successfully']);
    }
}
