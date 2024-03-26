<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return response()->json($drivers, Response::HTTP_OK);
    }

    public function show(String $id)
    {
        $driver = Driver::findOrFail($id);
        return response()->json($driver, Response::HTTP_OK);
    }
}
