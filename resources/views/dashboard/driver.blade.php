@extends('layouts.app')

@section('title', 'Driver Dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Driver Dashboard</h2>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Assigned Requests</h6>
                    <p class="h4 mb-0">{{ $assignedRequestsCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Accepted</h6>
                    <p class="h4 mb-0">{{ $acceptedRequestsCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">In Progress</h6>
                    <p class="h4 mb-0">{{ $inProgressRequestsCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h6 class="text-muted">Completed</h6>
                    <p class="h4 mb-0">{{ $completedRequestsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Requests List -->
    <div class="card shadow-sm">
        <div class="card-header">My Requests</div>
        <div class="card-body">
            @if($assignedRequests->isEmpty())
                <p class="text-muted">No requests assigned to you yet.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedRequests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->client->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge
                                        @if($request->status === 'assigned') bg-warning text-dark
                                        @elseif($request->status === 'accepted') bg-primary
                                        @elseif($request->status === 'in_progress') bg-info text-dark
                                        @elseif($request->status === 'completed') bg-success
                                        @else bg-secondary @endif">
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </td>
                                <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($request->status === 'assigned')
                                        <form action="{{ route('driver.requests.accept', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                        </form>
                                    @elseif($request->status === 'accepted')
                                        <form action="{{ route('driver.requests.start', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Start</button>
                                        </form>
                                    @elseif($request->status === 'in_progress')
                                        <form action="{{ route('driver.requests.complete', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">Complete</button>
                                        </form>
                                    @else
                                        <span class="text-muted">No action</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $assignedRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
