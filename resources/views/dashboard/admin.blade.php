@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h2>Welcome, {{ Auth::user()->name }} (Admin)</h2>
    <p>Here’s your administrative overview.</p>

    <!-- Stats Cards -->
    <div class="row my-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5>Total Clients</h5>
                    <h3>{{ $clientsCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5>Total Towing Requests</h5>
                    <h3>{{ $towingRequestsCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5>Active Drivers</h5>
                    <h3>{{ $driversCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5>Pending Requests</h5>
                    <h3>{{ $pendingRequestsCount ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Towing Requests Table -->
    <div class="card mt-4">
        <div class="card-header">
            Recent Towing Requests
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRequests as $request)
                    <tr>
                        <td>{{ $request->client->name }}</td>
                        <td>{{ $request->location }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>{{ $request->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No recent requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('categories.create') }}" cl
