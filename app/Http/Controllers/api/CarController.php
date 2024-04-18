<?php

namespace App\Http\Controllers\Api;


use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        if ($cars->isEmpty()) {
            return response()->json(['message' => 'No cars available'], 404);
        } else {
            return response()->json(['cars' => $cars], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $userId = auth()->id();
        $car = Car::create([
            //'user_id' => $userId,
            'car_name' => $request->car_name,
        ]);

        return response()->json(['car' => $car, 'message' => 'Car created successfully'], 201);
    }

    public function show(Car $car)
    {
        return response()->json(['car' => $car], 200);
    }

    public function update(Request $request, Car $car)
    {
        $validator = Validator::make($request->all(), [
            'car_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $car->update([
            'car_name' => $request->car_name,
        ]);

        return response()->json(['car' => $car, 'message' => 'Car updated successfully'], 200);
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return response()->json(['message' => 'Car deleted successfully'], 200);
    }
}
