@extends('layouts.app')

@section('title', 'Client Dashboard')

@section('content')
<div class="container">

    {{-- Dashboard Header --}}
    <div class="mb-4">
        <h2 class="fw-bold">Welcome, {{ Auth::user()->name }} 👋</h2>
        <p class="text-muted mb-0">
            Here is an overview of your towing requests.
        </p>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">

        {{-- Total Requests --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Requests</h6>
                    <h2 class="fw-bold text-primary">
                        {{ $totalRequestsCount ?? 0 }}
                    </h2>
                    <small class="text-muted">
                        All towing requests
                    </small>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Pending Requests</h6>
                    <h2 class="fw-bold text-warning">
                        {{ $pendingRequestsCount ?? 0 }}
                    </h2>
                    <small class="text-muted">
                        Waiting for processing
                    </small>
                </div>
            </div>
        </div>

        {{-- Completed --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Completed</h6>
                    <h2 class="fw-bold text-success">
                        {{ $completedRequestsCount ?? 0 }}
                    </h2>
                    <small class="text-muted">
                        Successfully completed
                    </small>
                </div>
            </div>
        </div>

        {{-- Unpaid --}}
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h6 class="text-muted">Unpaid Requests</h6>
                    <h2 class="fw-bold text-danger">
                        {{ $unpaidRequestsCount ?? 0 }}
                    </h2>
                    <small class="text-muted">
                        Payment pending
                    </small>
                </div>
            </div>
        </div>

    </div>

    {{-- Quick Actions --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Quick Actions</h5>

            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('towing.create') }}"
                   class="btn btn-success">
                    🚗 Request New Tow
                </a>

                <a href="{{ route('towing.index') }}"
                   class="btn btn-primary">
                    📋 My Towing Requests
                </a>

            </div>
        </div>
    </div>

    {{-- Recent Requests --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Recent Towing Requests</h5>
        </div>

        <div class="card-body">

            @if($recentRequests->isEmpty())

                <div class="text-center py-4">
                    <p class="text-muted mb-3">
                        You have not made any towing requests yet.
                    </p>

                    <a href="{{ route('towing.create') }}"
                       class="btn btn-success">
                        Request Your First Tow
                    </a>
                </div>

            @else

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Created</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($recentRequests as $request)

                                <tr>

                                    <td>
                                        #{{ $request->id }}
                                    </td>

                                    <td>
                                        <span class="badge
                                            @if($request->status === 'pending')
                                                bg-warning text-dark
                                            @elseif($request->status === 'completed')
                                                bg-success
                                            @elseif($request->status === 'assigned')
                                                bg-primary
                                            @elseif($request->status === 'in_progress')
                                                bg-info text-dark
                                            @elseif($request->status === 'rejected')
                                                bg-danger
                                            @else
                                                bg-secondary
                                            @endif">

                                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}

                                        </span>
                                    </td>

                                    <td>
                                        @if($request->payment_status === 'Paid')
                                            <span class="badge bg-success">
                                                Paid
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Unpaid
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $request->created_at->format('d M Y H:i') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('towing.index') }}"
                       class="btn btn-outline-primary">
                        View All Requests →
                    </a>
                </div>

            @endif

        </div>
    </div>

</div>
@endsection
