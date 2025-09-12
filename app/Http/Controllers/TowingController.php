<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Towing;
use App\Models\User;

class TowingController extends Controller
{
    // ===============================
    // Client Section
    // ===============================

    public function index()
    {
        $towings = Towing::where('user_id', auth()->id())->latest()->get();
        return view('towing.index', compact('towings'));
    }

    public function create()
    {
        return view('towing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string|max:255',
            'destination'     => 'required|string|max:255',
            'vehicle_type'    => 'required|string|max:100',
            'phone'           => 'required|string|max:15',
            'description'     => 'nullable|string',
        ]);

        $baseFare = 1000; // Ksh
        $perKmRate = 150; // Ksh per km
        $estimatedDistance = rand(5, 20); // Demo only
        $totalCost = $baseFare + ($perKmRate * $estimatedDistance);

        Towing::create([
            'user_id'         => auth()->id(),
            'pickup_location' => $request->pickup_location,
            'destination'     => $request->destination,
            'vehicle_type'    => $request->vehicle_type,
            'phone'           => $request->phone,
            'description'     => $request->description,
            'status'          => 'pending',
            'payment_status'  => 'Unpaid', // New field
            'price'           => $totalCost,
        ]);

        return redirect()->route('towing.index')
            ->with('success', 'Towing request created successfully!');
    }

    public function destroy($id)
    {
        $towing = Towing::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $towing->delete();

        return redirect()->route('towing.index')
            ->with('success', 'Towing request deleted successfully!');
    }

    // ===============================
    // Client Payment (Mock for School Project)
    // ===============================
    public function pay($id)
    {
        $towing = Towing::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($towing->status !== 'completed') {
            return redirect()->route('towing.index')
                ->with('error', 'Cannot pay before towing is completed.');
        }

        if ($towing->payment_status === 'Paid') {
            return redirect()->route('towing.index')
                ->with('info', 'This request is already paid.');
        }

        // Mock payment: instantly mark as Paid
        $towing->payment_status = 'Paid';
        $towing->save();

        return redirect()->route('towing.index')
            ->with('success', 'Payment completed successfully (mock).');
    }

    // ===============================
    // Admin Section
    // ===============================
    public function adminIndex()
    {
        $requests = Towing::with(['client', 'driver'])->latest()->paginate(10);
        return view('admin.requests.index', compact('requests'));
    }

    public function show($id)
    {
        $towing = Towing::with(['client', 'driver'])->findOrFail($id);

        $drivers = User::where('role', 'driver')
            ->where('status', 'approved')
            ->where('is_approved', true)
            ->get();

        return view('admin.requests.show', compact('towing', 'drivers'));
    }

    public function assignDriver(Request $request, $id)
    {
        $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);

        $towing = Towing::findOrFail($id);
        $towing->driver_id = $request->driver_id;
        $towing->status = 'assigned';
        $towing->save();

        return redirect()->route('admin.requests.show', $towing->id)
            ->with('success', 'Driver assigned successfully!');
    }

    public function approve($id)
    {
        $towing = Towing::findOrFail($id);
        $towing->status = 'approved';
        $towing->save();

        return redirect()->route('admin.requests.show', $id)
            ->with('success', 'Request approved successfully!');
    }

    public function reject($id)
    {
        $towing = Towing::findOrFail($id);
        $towing->status = 'rejected';
        $towing->save();

        return redirect()->route('admin.requests.show', $id)
            ->with('success', 'Request rejected successfully!');
    }

    // ===============================
    // Driver Section
    // ===============================
    public function acceptRequest($id)
    {
        $towing = Towing::findOrFail($id);

        if ($towing->driver_id !== auth()->id()) {
            return redirect()->route('driver.dashboard')->with('error', 'Unauthorized');
        }

        $towing->status = 'assigned';
        $towing->save();

        return redirect()->route('driver.dashboard')->with('success', 'Request accepted.');
    }

    public function startRequest($id)
    {
        $towing = Towing::findOrFail($id);

        if ($towing->driver_id !== auth()->id()) {
            return redirect()->route('driver.dashboard')->with('error', 'Unauthorized');
        }

        $towing->status = 'in_progress';
        $towing->save();

        return redirect()->route('driver.dashboard')->with('success', 'Request started.');
    }

    public function completeRequest($id)
    {
        $towing = Towing::findOrFail($id);

        if ($towing->driver_id !== auth()->id()) {
            return redirect()->route('driver.dashboard')->with('error', 'Unauthorized');
        }

        $towing->status = 'completed';
        $towing->save();

        return redirect()->route('driver.dashboard')->with('success', 'Request marked as completed.');
    }
}
