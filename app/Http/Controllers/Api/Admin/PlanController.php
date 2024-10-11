<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    protected $updateplan=['offer_name','price','price_discount','duration'];
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
        $offer->price_discount=$request->price_discount;
        $offer->duration=$request->duration;
        $offer->save();
        return response()->json(['message' => 'plan added successfully']);
    }

    public function destroy($id){
        $offer= Offer::findOrFail($id);
        $offer->delete();
        return response()->json(['message' => 'plan deleted successfully']);
    }

    public function update(Request $request, $id){
        $offer = Offer::findOrFail($id);
        $offer->update($request->only($this->updateplan));
        return response()->json(['message' => 'plan updated successfully']);
    }
}
