@extends('layouts.app')

@section('title', 'Client Dashboard')

@section('content')
<div class="container">
    <h2>Welcome, {{ Auth::user()->name }} (Client)</h2>
    <p>Here’s your client overview.</p>

    <!-- Your Towing Requests Stats -->
    <div class="row my-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5>Total Towing Requests</h5>
                    <h3>{{ $towingRequestsCount ?? 0 }}</h3>
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

    <!-- Your Recent Towing Requests Table -->
    <div class="card mt-4">
        <div class="card-header">
            Your Recent Towing Requests
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentRequests as $request)
                        <tr>
                            <td>{{ $request->location }}</td>
                            <td>{{ ucfirst($request->status) }}</td>
                            <td>{{ $request->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">You have no towing requests.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('towing.create') }}" class="btn btn-success">Request New Tow</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">View Categories</a>
    </div>
</div>
@endsection
