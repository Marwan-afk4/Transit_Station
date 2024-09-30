<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Parking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ParkingController extends Controller
{

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
        $car = Parking::where('id', $id)
            ->with(['car' => function ($query) {
                $query->select('cars.id', 'car_name');
            }])
            ->first()
            ->car;

        $carowner = Car::where('id', $id)
            ->with(['user' => function ($query) {
                $query->select('users.id', 'name');
            }])
            ->first()
            ->user;

        $data = [
            'cars' => $car,
            'carowner' => $carowner
        ];

        return response()->json($data);
    }

//     public function updateCar(Request $request, $id)
// {
//     // Find the car by ID
//     $car = Car::find($id);

//     if (!$car) {
//         return response()->json(['message' => 'Car not found'], 404);
//     }

//     // Update the car details with the request data
//     $car->car_name = $request->input('car_name', $car->car_name);
//     $car->car_number = $request->input('car_number', $car->car_number);

//     // Save the updated car data
//     $car->save();

//     return response()->json([
//         'message' => 'Car updated successfully',
//         'car' => $car
//     ], 200);
// }

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

}
