@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2>Welcome, {{ Auth::user()->name }}</h2>
    <p>Here’s your overview for today.</p>

    <!-- Stats Cards -->
    <div class="row my-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5>Total Clients</h5>
                    <h3>{{ $clientsCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5>Towing Requests</h5>
                    <h3>{{ $towingRequestsCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5>Active Drivers</h5>
                    <h3>{{ $driversCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5>Pending Requests</h5>
                    <h3>{{ $pendingRequestsCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests Table -->
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
                        <td colspan="4" class="text-center">No requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">View Categories</a>
        <a href="{{ route('towing.create') }}" class="btn btn-success">New Towing Request</a>
    </div>
</div>
@endsection
