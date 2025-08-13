<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\TowingRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats
        $clientsCount = User::where('role', 'client')->count();
        $towingRequestsCount = TowingRequest::count();
        $driversCount = User::where('role', 'driver')->count();
        $pendingRequestsCount = TowingRequest::where('status', 'pending')->count();

        // Latest 5 towing requests
        $recentRequests = TowingRequest::with('client')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'clientsCount',
            'towingRequestsCount',
            'driversCount',
            'pendingRequestsCount',
            'recentRequests'
        ));
    }
}
