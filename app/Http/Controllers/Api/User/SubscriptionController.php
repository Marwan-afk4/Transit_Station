<?php

namespace App\Http\Controllers\Api\User;

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
                'offer_name' => $subscription->offer->offer_name ??null,
                'start_date' => $subscription->start_date ??null,
                'end_date' => $subscription->end_date ?? null,
                'status' => $subscription->status,
            ];
        });

        return response()->json(['user' => $userSubscriptions, 'offers' => $offers]);
    }
}
