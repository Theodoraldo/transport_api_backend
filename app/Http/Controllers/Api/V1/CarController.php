<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Response;
use App\Http\Resources\V1\CarResource;
use App\Exceptions\ExceptionHandler;

class CarController extends Controller
{
    public function index()
    {
        try {
            $cars = CarResource::collection(Car::get());
            return response()->json($cars, Response::HTTP_OK);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function store(Request $request)
    {
        try {
            Car::create($request->all());
            return response()->json(['status' => Response::HTTP_CREATED, 'message' => 'Created Successfully !!!'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function show(String $id)
    {
        try {
            $car = new CarResource(Car::findOrFail($id));
            return response()->json($car, Response::HTTP_OK);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->update($request->all());
            return response()->json(['status' => Response::HTTP_OK, 'message' => 'Updated Successfully !!!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }

    public function destroy(string $id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete();
            return response()->json(['status' => Response::HTTP_OK, 'message' => 'Deleted Successfully !!!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return ExceptionHandler::handleException($e);
        }
    }
}
