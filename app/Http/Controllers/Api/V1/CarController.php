<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CarController extends Controller
{
    public function index()
    {
        try {
            $cars = Car::all();
            return response()->json($cars, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            Car::create($request->all());
            return response()->json("Created Successfully", Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not create car'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(String $id)
    {
        try {
            $car = Car::findOrFail($id);
            return response()->json($car, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Car not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->update($request->all());
            return response()->json("Updated Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Car not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not update car'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(string $id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete();
            return response()->json("Deleted Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Car not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not delete car'], Response::HTTP_BAD_REQUEST);
        }
    }
}
