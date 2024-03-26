<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\TripInfo;
use Illuminate\Http\Response;

class TripInfoController extends Controller
{
    public function index() {
        $trips = TripInfo::with('car','driver')->get();
        return response()->json($trips, Response::HTTP_OK);
    }

    public function show(String $id)
    {
        $trip = TripInfo::with('car', 'driver')->findOrFail($id);
        return response()->json($trip, Response::HTTP_OK);
    }
}
