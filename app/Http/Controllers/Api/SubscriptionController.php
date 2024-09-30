<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscription(Request $request)
    {
        $offers = Offer::all();
        $user = $request->user();

        // Get user subscriptions with the related offer names
        $userSubscriptions = $user->subscription()->with('offer:id,offer_name')->get()->map(function($subscription) {
            return [
                'id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'offer_name' => $subscription->offer->offer_name,
                'start_date' => $subscription->start_date,
                'end_date' => $subscription->end_date,
                'status' => $subscription->status,
            ];
        });

        return response()->json(['user' => $userSubscriptions, 'offers' => $offers]);
    }
}
