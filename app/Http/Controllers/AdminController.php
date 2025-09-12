<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Towing;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin dashboard
    public function dashboard()
    {
        $clientsCount = User::where('role', 'client')->count();
        $driversCount = User::where('role', 'driver')->count();
        $towingRequestsCount = Towing::count();
        $pendingRequestsCount = Towing::where('status', 'pending')->count();

        $recentRequests = Towing::with(['client', 'driver'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.admin', compact(
            'clientsCount',
            'driversCount',
            'towingRequestsCount',
            'pendingRequestsCount',
            'recentRequests'
        ));
    }

    // List all drivers with pagination
    public function drivers()
    {
        $drivers = User::where('role', 'driver')->paginate(10);
        return view('admin.drivers.index', compact('drivers'));
    }

    public function approveDriver($id)
    {
        $driver = User::findOrFail($id);
        $driver->status = 'approved';
        $driver->is_approved = true;
        $driver->save();

        return back()->with('success', 'Driver approved successfully!');
    }

    public function rejectDriver($id)
    {
        $driver = User::findOrFail($id);
        $driver->status = 'rejected';
        $driver->is_approved = false;
        $driver->save();

        return back()->with('success', 'Driver rejected successfully!');
    }

    // Show towing requests for admin to assign
    public function towingRequests()
    {
        $requests = Towing::with(['client', 'driver'])
            ->latest()
            ->paginate(10);

        // Only approved drivers for assignment
        $drivers = User::where('role', 'driver')
            ->where('is_approved', true)
            ->get();

        return view('admin.requests.index', compact('requests', 'drivers'));
    }

    // Assign a driver to a request
    public function assignDriver(Request $request, $id)
    {
        $request->validate([
            'driver_id' => 'required|exists:users,id',
        ]);

        $towingRequest = Towing::findOrFail($id);
        $towingRequest->driver_id = $request->driver_id;
        $towingRequest->status = 'assigned';
        $towingRequest->save();

        return back()->with('success', 'Driver assigned successfully!');
    }
}
