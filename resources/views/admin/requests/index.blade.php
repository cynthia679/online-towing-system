@extends('layouts.app')

@section('title', 'Manage Towing Requests')

@section('content')
<div class="container">
    <h2 class="mb-4">Towing Requests</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Driver</th>
                <th>Status</th>
                <th>Requested At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->client->name ?? 'N/A' }}</td>
                    <td>{{ $request->driver->name ?? 'Unassigned' }}</td>
                    <td>
                        @if($request->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($request->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($request->status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-secondary">Unknown</span>
                        @endif
                    </td>
                    <td>{{ $request->created_at->format('d M Y H:i') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.requests.show', $request->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No towing requests found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
