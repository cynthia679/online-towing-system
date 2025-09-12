@extends('layouts.app')

@section('title', 'Request Details')

@section('content')
<div class="container">
    <h2 class="mb-4">Request Details</h2>

    <div class="card p-4 mb-3">
        <p><strong>ID:</strong> {{ $towing->id }}</p>
        <p><strong>User:</strong> {{ $towing->client->name ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($towing->status) }}</p>
        <p><strong>Driver:</strong> {{ $towing->driver->name ?? 'Not Assigned' }}</p>
        <p><strong>Created At:</strong> {{ $towing->created_at }}</p>
    </div>

    {{-- Approve / Reject --}}
    <div class="d-flex gap-2 mb-3">
        <form action="{{ route('admin.requests.approve', $towing->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Approve</button>
        </form>

        <form action="{{ route('admin.requests.reject', $towing->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Reject</button>
        </form>
    </div>

    {{-- Assign Driver --}}
    @if($towing->status === 'approved' || $towing->status === 'assigned')
    <div class="card p-4">
        <h5>Assign Driver</h5>
        <form action="{{ route('admin.requests.assign', $towing->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="driver_id" class="form-label">Select Driver</label>
                <select name="driver_id" id="driver_id" class="form-select" required>
                    <option value="">-- Choose Approved Driver --</option>
                    @foreach($drivers as $driver)
                        <option value="{{ $driver->id }}"
                            {{ $towing->driver_id == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }} ({{ $driver->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Assign Driver</button>
        </form>
    </div>
    @endif
</div>
@endsection
