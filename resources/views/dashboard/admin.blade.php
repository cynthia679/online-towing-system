@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard</h2>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Clients</h6>
                    <p class="h4 mb-0">{{ $clientsCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Drivers</h6>
                    <p class="h4 mb-0">{{ $driversCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Requests</h6>
                    <p class="h4 mb-0">{{ $towingRequestsCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Pending Requests</h6>
                    <p class="h4 mb-0">{{ $pendingRequestsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests Table -->
    <h4 class="mb-3">Recent Towing Requests</h4>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Client</th>
                    <th>Driver</th>
                    <th>Pickup</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentRequests as $request)
                    <tr>
                        <td>{{ $request->client->name ?? 'N/A' }}</td>
                        <td>{{ $request->driver->name ?? 'Unassigned' }}</td>
                        <td>{{ $request->pickup_location }}</td>
                        <td>{{ $request->destination }}</td>
                        <td>
                            <span class="badge
                                @if($request->status == 'pending') bg-warning
                                @elseif($request->status == 'assigned') bg-info
                                @elseif($request->status == 'completed') bg-success
                                @else bg-secondary @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.requests.show', $request->id) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No recent requests</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
