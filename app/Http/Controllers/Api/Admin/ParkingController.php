<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Parking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParkingController extends Controller
{

    protected $parkingupdate=['name','capacity','location'];
    public function showparking()
    {
        $parkingdata = Parking::all();
        $data = [
            'data' => $parkingdata
        ];
        return response()->json($data);
    }

    public function addparking(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'capacity' => 'required|integer',
            'location' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $validate = Parking::create([
            'name' => $request->name,
            'capacity' => (int)$request->capacity,
            'location' => $request->location
        ]);

        $data = [
            'message' => 'parking added successfully',
            'data' => $validate
        ];

        return response()->json($data);
    }

    public function CarParking($id)
{
    $data = Parking::where('id', $id)
        ->with('car.user.subscription.offer')
        ->first();

    $data = [
        'car' => $data->car->map(function($car) {
            $user = $car->user;
            $subscriptions = $user->subscription->map(function($subscription) {
                return [
                    'offer_name' => $subscription->offer->offer_name, // Access offer name
                    'start_date' => $subscription->start_date,
                ];
            });

            return [
                'id' => $car->id,
                'car_number' => $car->car_number,
                'car_name' => $car->car_name,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'subscriptions' => $subscriptions,
                ]
            ];
        }),
    ];

    return response()->json($data);
}


    public function update(Request $request, $id){
        $parking = Parking::findOrFail($id);
        $parking->update($request->only($this->parkingupdate));
        return response()->json(['message' => 'parking updated successfully']);
    }

public function deleteCar($id)
{
    // Find the car by ID
    $car = Car::find($id);

    if (!$car) {
        return response()->json(['message' => 'Car not found'], 404);
    }

    // Delete the car
    $car->delete();

    return response()->json(['message' => 'Car deleted successfully'], 200);
}


public function destroy($id)
{
    $parking = Parking::find($id);
    $parking->delete();
    return response()->json(['message' => 'parking deleted successfully']);
}

}
