<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Revenue;
use App\Models\TypeRevenue;
use Illuminate\Http\Request;

class RevenueController extends Controller
{

    protected $revenueupdate=['revenue_amount','date','type_revenue_id'];

    public function showrevenue()
    {
        $revenue = Revenue::with('type_revenue')->get();
        $revenueAmount=Revenue::sum('revenue_amount');
        $revenuedata = $revenue->map(function ($revenue) {
            return [
                'id' => $revenue->id,
                'type' => $revenue->type_revenue->type_name,
                'revenue_amount' => $revenue->revenue_amount,
                'date' => $revenue->date
            ];
        });
        $data=[
            'revenueAmount'=>$revenueAmount,
            'revenues'=>$revenuedata
        ];
        return response()->json($data);
    }

    public function update(Request $request, $id){
        $revenue = Revenue::findOrFail($id);
        $revenue->update($request->only($this->revenueupdate));
        return response()->json(['message' => 'Revenue updated successfully']);
    }

    public function destroy($id)
    {
        $revenue = Revenue::findOrFail($id);
        $revenue->delete();
        return response()->json(['message' => 'Revenue deleted successfully']);
    }

    public function revenuetypes(){
        $types=TypeRevenue::all();

        return response()->json(['tiztamer'=>$types]);
    }

    public function addrevenue(Request $request){
        $revenue = new Revenue();
        $revenue->revenue_amount = $request->revenue_amount;
        $revenue->date = $request->date;
        $revenue->type_revenue_id = $request->type_revenue_id;
        $revenue->save();
        return response()->json(['message' => 'Revenue added successfully']);
    }

    public function addrevenueType(Request $request){
        $type = new TypeRevenue();
        $type->type_name = $request->type_name;
        $type->save();
        return response()->json(['message' => 'Revenue type added successfully']);
    }
}
