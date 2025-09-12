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

    <!-- Quick Action Buttons -->
    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('towing.create') }}" class="btn btn-success">Request New Tow</a>
        <a href="{{ route('towing.index') }}" class="btn btn-secondary">My Towing Requests</a>
    </div>
</div>
@endsection
