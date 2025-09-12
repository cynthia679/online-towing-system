@extends('layouts.app')

@section('title', 'My Towing Requests')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">My Towing Requests</h2>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if($towings->isEmpty())
        <p>You have not made any towing requests yet.</p>
        <a href="{{ route('towing.create') }}" class="btn btn-primary">Request Towing Service</a>
    @else
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pickup</th>
                    <th>Destination</th>
                    <th>Vehicle Type</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Driver</th>
                    <th>Payment</th>
                    <th>Price (KES)</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($towings as $towing)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $towing->pickup_location }}</td>
                        <td>{{ $towing->destination }}</td>
                        <td>{{ $towing->vehicle_type }}</td>
                        <td>{{ $towing->phone }}</td>
                        <td>
                            <span class="badge
                                @if(strtolower(trim($towing->status)) === 'pending') bg-warning
                                @elseif(strtolower(trim($towing->status)) === 'in_progress') bg-info
                                @elseif(strtolower(trim($towing->status)) === 'completed') bg-success
                                @else bg-secondary @endif">
                                {{ ucfirst($towing->status) }}
                            </span>
                        </td>
                        <td>
                            @if($towing->driver)
                                {{ $towing->driver->name }}
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </td>
                        <td>
                            @if(strtolower(trim($towing->payment_status)) === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-danger">Unpaid</span>
                            @endif
                        </td>
                        <td>{{ number_format($towing->price, 2) }}</td>
                        <td>{{ $towing->created_at->format('d M Y H:i') }}</td>
                        <td class="d-flex flex-column gap-2">
                            {{-- Pay Now button --}}
                            @if(strtolower(trim($towing->status)) === 'completed' && strtolower(trim($towing->payment_status)) === 'unpaid')
                                <form action="{{ route('towing.pay', $towing->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm w-100">Pay Now</button>
                                </form>
                            @endif

                            {{-- Delete button for pending requests --}}
                            @if(strtolower(trim($towing->status)) === 'pending')
                                <form action="{{ route('towing.destroy', $towing->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this request?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
