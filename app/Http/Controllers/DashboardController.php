<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Towing;
use App\Models\User;

class DashboardController extends Controller
{
    // =========================
    // Client Dashboard
    // =========================
    public function client()
    {
        $recentRequests = Towing::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $totalRequestsCount = Towing::where('user_id', auth()->id())->count();
        $pendingRequestsCount = Towing::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        $completedRequestsCount = Towing::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->count();

        $unpaidRequestsCount = Towing::where('user_id', auth()->id())
            ->where('payment_status', 'Unpaid')
            ->count();

        return view('dashboard.client', compact(
            'recentRequests',
            'totalRequestsCount',
            'pendingRequestsCount',
            'completedRequestsCount',
            'unpaidRequestsCount'
        ));
    }

    // =========================
    // Admin Dashboard
    // =========================
    public function admin()
    {
        $clientsCount = User::where('role', 'client')->count();
        $driversCount = User::where('role', 'driver')->count();
        $towingRequestsCount = Towing::count();
        $pendingRequestsCount = Towing::where('status', 'pending')->count();

        $recentRequests = Towing::with(['client', 'driver'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'clientsCount',
            'driversCount',
            'towingRequestsCount',
            'pendingRequestsCount',
            'recentRequests'
        ));
    }

    // =========================
    // Driver Dashboard
    // =========================
    public function driver()
    {
        $driverId = auth()->id();

        $assignedRequestsCount = Towing::where('driver_id', $driverId)
            ->where('status', 'assigned')
            ->count();

        $pendingRequestsCount = Towing::where('driver_id', $driverId)
            ->where('status', 'pending')
            ->count();

        $recentRequests = Towing::with('client')
            ->where('driver_id', $driverId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.driver', compact(
            'recentRequests',
            'assignedRequestsCount',
            'pendingRequestsCount'
        ));
    }
}
