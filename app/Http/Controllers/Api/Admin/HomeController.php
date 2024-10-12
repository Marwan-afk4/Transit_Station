<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Expence;
use App\Models\Location;
use App\Models\Parking;
use App\Models\Request as ModelsRequest;
use App\Models\Revenue;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function HomePage(Request $request){
        $PickupLocationCount=Location::count();
        $parkingCount=Parking::count();
        $usercount=User::count();
        $requestcount=ModelsRequest::where('status',1)->count();
        $SubscriptionCount=Subscription::count();
        $DriverCount=Driver::count();
        $revenueAmount=Revenue::sum('revenue_amount');
        $expenceAmount=Expence::sum('expence_amount');

        $locationdata=Location::all();
        $parkingdata=Parking::all();
        $driverdata=Driver::all();
        $revenuedata=Revenue::with('type_revenue')->get()->map(function ($revenue){
            return [
                'id'=>$revenue->id,
                'revenue_amount'=>$revenue->revenue_amount,
                'type_name'=>$revenue->type_revenue->type_name,
                'date'=>$revenue->date
            ];
        });

        $expencedata=Expence::with('type_expence')->get()->map(function ($expence){
            return [
                'id'=>$expence->id,
                'expence_amount'=>$expence->expence_amount,
                'type_name'=>$expence->type_expence->type_name,
                'date'=>$expence->date
            ];
        });

        $dataCount=[
            'usercount'=>$usercount,
            'requestcount'=>$requestcount,
            'PickupLocationCount'=>$PickupLocationCount,
            'parkingCount'=>$parkingCount,
            'SubscriptionCount'=>$SubscriptionCount,
            'DriverCount'=>$DriverCount,
            'revenueAmount'=>$revenueAmount,
            'expenceAmount'=>$expenceAmount
        ];
        $datainfo=[
            'locationdata'=>$locationdata,
            'padkingdata'=>$parkingdata,
            'driverdata'=>$driverdata,
            'revenuedata'=>$revenuedata,
            'expencedata'=>$expencedata
        ];

        return response()->json([$dataCount,$datainfo]);

    }

    public function logout(Request $request){
        $user=$request->user();
        $user->currentAccessToken()->delete();
        return response()->json(['message'=>'logged out successfully']);
    }
}


