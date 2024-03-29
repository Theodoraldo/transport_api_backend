<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Http\Controllers\Controller;
use App\Models\TripInfo;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class TripInfoController extends Controller
{
    public function index()
    {
        try {
            $trips = TripInfo::with('car', 'driver')->get();
            return response()->json($trips, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(String $id)
    {
        try {
            $trip = TripInfo::with('car', 'driver')->findOrFail($id);
            return response()->json($trip, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Trip details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            TripInfo::create($request->all());
            return response()->json("Created Successfully", Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not create trip'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            TripInfo::findOrFail($id)->update($request->all());
            return response()->json("Updated Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Trip details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not update trip'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(string $id)
    {
        try {
            TripInfo::findOrFail($id)->delete();
            return response()->json("Deleted Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Trip details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not delete trip record'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateQuantity(Request $request, string $id)
    {
        try {
            $trip = TripInfo::findOrFail($id);
            $quantity = $request->input('quantity_sold');
            $trip->increment('quantity_sold', $quantity);

            return response()->json("Issued ticket Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Trip details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not issue ticket at this time'], Response::HTTP_BAD_REQUEST);
        }
    }
}
