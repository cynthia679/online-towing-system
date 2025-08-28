<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function calculate(Request $request)
    {
        $pickup = $request->query('pickup');
        $destination = $request->query('destination');

        if ($pickup && $destination) {
            // Example formula (replace with your own logic)
            $price = 100 + (abs(strlen($pickup) - strlen($destination)) * 50);

            return response()->json(['price' => $price]);
        }

        return response()->json(['error' => 'Missing pickup or destination'], 400);
    }
}
