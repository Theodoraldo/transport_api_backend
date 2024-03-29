<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Models\Booking;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {

        try {
            $bookings = Booking::with('mobileuser', 'tripinfo')->get();
            return response()->json($bookings, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(String $id)
    {
        try {
            $booking = Booking::with('mobileuser', 'tripinfo')->findOrFail($id);
            return response()->json($booking, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            Booking::create($request->all());
            return response()->json("Created Successfully", Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not create booking'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            Booking::findOrFail($id)->update($request->all());
            return response()->json("Updated Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not update booking'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(string $id)
    {
        try {
            Booking::findOrFail($id)->delete();
            return response()->json("Deleted Successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking details not found'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not delete booking record'], Response::HTTP_BAD_REQUEST);
        }
    }
}
