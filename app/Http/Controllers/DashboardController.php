<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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

        return view('dashboard.client', compact(
            'recentRequests',
            'totalRequestsCount',
            'pendingRequestsCount'
        ));
    }

    // =========================
    // Admin Dashboard
    // =========================
    public function admin()
    {
        $clientsCount = User::where('role', 'client')->count();
        $towingRequestsCount = Towing::count();
        $driversCount = User::where('role', 'driver')->count();
        $pendingRequestsCount = Towing::where('status', 'pending')->count();

        $recentRequests = Towing::with('user') // Assuming 'user' relationship exists
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'clientsCount',
            'towingRequestsCount',
            'driversCount',
            'pendingRequestsCount',
            'recentRequests'
        ));
    }

    // =========================
    // Driver Dashboard
    // =========================
    public function driver()
    {
        $recentRequests = Towing::where('driver_id', auth()->id()) // Keep if assigning drivers
            ->latest()
            ->take(5)
            ->get();

        $assignedRequestsCount = Towing::where('driver_id', auth()->id())->count();
        $pendingRequestsCount = Towing::where('driver_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        return view('dashboard.driver', compact(
            'recentRequests',
            'assignedRequestsCount',
            'pendingRequestsCount'
        ));
    }
}
