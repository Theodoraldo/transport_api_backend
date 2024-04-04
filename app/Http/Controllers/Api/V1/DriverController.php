<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        try {
            $drivers = Driver::all();
            return response()->json($drivers, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            Driver::create($request->all());
            return response()->json("Created Successfully", Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not create driver'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(String $id)
    {
        try {
            $driver = Driver::findOrFail($id);
            return response()->json($driver, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Driver details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            Driver::findOrFail($id)->update($request->all());
            return response()->json("Updated Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Driver details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not update driver'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(string $id)
    {
        try {
            Driver::findOrFail($id)->delete();
            return response()->json("Deleted Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Driver details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not delete driver record'], Response::HTTP_BAD_REQUEST);
        }
    }
}
