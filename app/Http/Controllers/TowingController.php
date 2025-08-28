<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Towing;

class TowingController extends Controller
{
    // Show list of towing requests
    public function index()
    {
        $towings = Towing::where('user_id', auth()->id())->latest()->get();
        return view('towing.index', compact('towings'));
    }

    // Show the form to create a towing request
    public function create()
    {
        return view('towing.create');
    }

    // Store a new towing request
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'pickup_location' => 'required|string|max:255',
            'destination'     => 'required|string|max:255',
            'vehicle_type'    => 'required|string|max:100',
            'phone'           => 'required|string|max:15',
            'description'     => 'nullable|string',
        ]);

        // --- Step 1: Calculate cost ---
        $baseFare = 1000; // Ksh
        $perKmRate = 150; // Ksh per km
        $estimatedDistance = rand(5, 20); // Demo only
        $totalCost = $baseFare + ($perKmRate * $estimatedDistance);

        // --- Step 2: Save towing request with price ---
        $towing = Towing::create([
            'user_id'        => auth()->id(),
            'pickup_location'=> $request->pickup_location,
            'destination'    => $request->destination,
            'vehicle_type'   => $request->vehicle_type,
            'phone'          => $request->phone,
            'description'    => $request->description,
            'status'         => 'pending',
            'price'          => $totalCost,
        ]);

        // --- Step 3: Redirect back with success message ---
        return redirect()->route('towing.index')
            ->with('success', 'Towing request created successfully!');
    }
}
