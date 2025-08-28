@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Clients</h6>
                    <p class="h4">{{ $clientsCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Drivers</h6>
                    <p class="h4">{{ $driversCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Requests</h6>
                    <p class="h4">{{ $towingRequestsCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Pending Requests</h6>
                    <p class="h4">{{ $pendingRequestsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Recent Towing Requests</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Client</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentRequests as $request)
                <tr>
                    <td>{{ $request->client->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($request->status) }}</td>
                    <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No recent requests</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
