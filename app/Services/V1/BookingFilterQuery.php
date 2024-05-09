<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class BookingFilterQuery
{
    public function transform(Request $request)
    {
        $queryItems = [];

        if ($request->has('bored')) {
            $queryItems['bored'] = $request->input('bored');
        }

        return $queryItems;
    }
}
