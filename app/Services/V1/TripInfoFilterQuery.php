<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class TripInfoFilterQuery
{
    public function transform(Request $request)
    {
        $queryItems = [];

        if ($request->has('mode')) {
            $queryItems['mode'] = $request->input('mode');
        }

        if ($request->has('completed')) {
            $queryItems['completed'] = $request->input('completed');
        }

        return $queryItems;
    }
}
