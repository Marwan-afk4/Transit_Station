<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expence;
use App\Models\TypeExpence;
use Illuminate\Http\Request;

class ExpenceController extends Controller
{
    protected $expenceupdate = ['expence_amount','date','type_expence_id'];

    public function showexcpence(){
        $expence = Expence::with('type_expence')->get();
        $expenceamount = Expence::sum('expence_amount');
        $expencedata = $expence->map(function ($expence) {
            return [
                'id' => $expence->id,
                'type' => $expence->type_expence->type_name,
                'expence_amount' => $expence->expence_amount,
                'date' => $expence->date
            ];
        });
        $data=[
            'expenceamount'=>$expenceamount,
            'expences'=>$expencedata
        ];
        return response()->json($data);
    }

    public function update(Request $request, $id){
        $expence = Expence::findOrFail($id);
        $expence->update($request->only($this->expenceupdate));
        return response()->json(['message' => 'Expence updated successfully']);
    }

    public function destroy($id)
    {
        $expence = Expence::findOrFail($id);
        $expence->delete();
        return response()->json(['message' => 'Expence deleted successfully']);
    }

    public function expencetypes(){
        $types=TypeExpence::all();
        return response()->json(['tiztamer'=>$types]);
    }

    public function addexpence(Request $request){
        $expence = new Expence();
        $expence->expence_amount = $request->expence_amount;
        $expence->date = $request->date;
        $expence->type_expence_id = $request->type_expence_id;
        $expence->save();
        return response()->json(['message' => 'Expence added successfully']);
    }

    public function addexpencetype(Request $request){
        $type = new TypeExpence();
        $type->type_name = $request->type_name;
        $type->save();
        return response()->json(['message' => 'Expence type added successfully']);
    }

}
