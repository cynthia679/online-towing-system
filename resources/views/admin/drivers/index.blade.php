@extends('layouts.app')

@section('title', 'Manage Drivers')

@section('content')
<div class="container">
    <h2 class="mb-4">Drivers</h2>

    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($drivers as $driver)
                <tr>
                    <td>{{ $driver->id }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->email }}</td>
                    <td>
                        @php
                            $status = strtolower(trim($driver->status));
                        @endphp

                        @if($status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($status === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-secondary">Unknown ({{ $driver->status }})</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($status === 'pending')
                            {{-- Approve --}}
                            <form action="{{ route('admin.drivers.approve', $driver->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success me-1">Approve</button>
                            </form>

                            {{-- Reject --}}
                            <form action="{{ route('admin.drivers.reject', $driver->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                            </form>
                        @else
                            <span class="text-muted">No action</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No drivers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $drivers->links() }}
    </div>
</div>
@endsection
