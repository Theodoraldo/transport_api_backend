<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class BookingFilterQuery
{
    public function transform(Request $request)
    {
        $queryItems = [];

        if ($request->has('status')) {
            $queryItems['status'] = $request->input('status');
        }

        return $queryItems;
    }
}
