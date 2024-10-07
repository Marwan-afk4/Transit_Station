<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function showplans(Request $request){
        $plans= Offer::all();
        $data=[
            'plans'=>$plans
        ];
        return response()->json($data);
    }

    public function addplan(Request $request){
        $offer= new Offer();
        $offer->offer_name=$request->offer_name;
        $offer->price=$request->price;
        $offer->duration=$request->duration;
        $offer->price_discount=$request->price_discount;
        $offer->save();
        return response()->json(['message' => 'plan added successfully']);
    }

    public function destroy($id){
        $offer= Offer::findOrFail($id);
        $offer->delete();
        return response()->json(['message' => 'plan deleted successfully']);
    }
}
