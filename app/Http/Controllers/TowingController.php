<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Towing; // Make sure you have a Towing model

class TowingController extends Controller
{
    // Show the form to create a towing request
    public function create()
    {
        return view('towing.create'); // Blade view: resources/views/towing/create.blade.php
    }

    // Store a new towing request
    public function store(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        Towing::create([
            'user_id' => auth()->id(),
            'pickup_location' => $request->pickup_location,
            'destination' => $request->destination,
            'vehicle_type' => $request->vehicle_type,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('client.dashboard')->with('success', 'Towing request submitted!');
    }

    // Optional: list all towing requests (for admin or driver)
    public function index()
    {
        $towings = Towing::all();
        return view('towing.index', compact('towings'));
    }
}
