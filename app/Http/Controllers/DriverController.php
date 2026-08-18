<?php

namespace App\Http\Controllers;

use App\Models\Towing;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function dashboard()
    {
        $driverId = Auth::id();

        // Stats
        $assignedRequestsCount = Towing::where('driver_id', $driverId)->where('status', 'assigned')->count();
        $acceptedRequestsCount = Towing::where('driver_id', $driverId)->where('status', 'accepted')->count();
        $inProgressRequestsCount = Towing::where('driver_id', $driverId)->where('status', 'in_progress')->count();
        $completedRequestsCount = Towing::where('driver_id', $driverId)->where('status', 'completed')->count();

    // All requests assigned to this driver
    $assignedRequests = Towing::with('client')
        ->where('driver_id', $driverId)
        ->latest()
        ->paginate(10);

        // Driver earnings
        // Driver receives 90% after customer payment is confirmed.
        $paidCompletedRequests = Towing::where('driver_id', $driverId)
            ->where('status', 'completed')
            ->where('payment_status', 'Paid')
            ->get();

        $totalEarnings = $paidCompletedRequests->sum(function ($towing) {
            return (float) $towing->price * 0.90;
        });

        // Completed jobs waiting for customer payment
        $pendingEarnings = Towing::where('driver_id', $driverId)
            ->where('status', 'completed')
            ->where(function ($query) {
                $query->whereNull('payment_status')
                    ->orWhere('payment_status', '!=', 'Paid');
            })
            ->sum('price');

        $paidCompletedCount = $paidCompletedRequests->count();

        return view('dashboard.driver', compact(
            'assignedRequests',
            'assignedRequestsCount',
            'acceptedRequestsCount',
            'inProgressRequestsCount',
            'completedRequestsCount',
            'totalEarnings',
            'pendingEarnings',
            'paidCompletedCount'
        ));
    }

    // Accept assigned request
    public function acceptRequest($id)
    {
        $towing = Towing::findOrFail($id);

        if ($towing->driver_id != Auth::id()) {
            return back()->with('error', 'You are not assigned to this request.');
        }

        if ($towing->status !== 'assigned') {
            return back()->with('error', 'Request cannot be accepted.');
        }

        $towing->update(['status' => 'accepted']);

        return back()->with('success', 'Request accepted.');
    }

    // Mark request as in-progress
    public function startRequest($id)
    {
        $towing = Towing::findOrFail($id);

        if ($towing->driver_id != Auth::id()) {
            return back()->with('error', 'You are not assigned to this request.');
        }

        if ($towing->status !== 'accepted') {
            return back()->with('error', 'Request cannot be started.');
        }

        $towing->update(['status' => 'in_progress']);

        return back()->with('success', 'Request started.');
    }

    // Mark request as completed
    public function completeRequest($id)
    {
        $towing = Towing::findOrFail($id);

        if ($towing->driver_id != Auth::id()) {
            return back()->with('error', 'You are not assigned to this request.');
        }

        if ($towing->status !== 'in_progress') {
            return back()->with('error', 'Request cannot be completed.');
        }

        $towing->update(['status' => 'completed']);

        return back()->with('success', 'Request completed.');
    }
}
