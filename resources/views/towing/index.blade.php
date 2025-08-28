@extends('layouts.app')

@section('title', 'My Towing Requests')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">My Towing Requests</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($towings->isEmpty())
        <p>You have not made any towing requests yet.</p>
        <a href="{{ route('towing.create') }}" class="btn btn-primary">Request Towing Service</a>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pickup</th>
                    <th>Destination</th>
                    <th>Vehicle Type</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Price (KES)</th>
                    <th>Date</th>
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
                                @if($towing->status == 'pending') bg-warning
                                @elseif($towing->status == 'completed') bg-success
                                @else bg-secondary @endif">
                                {{ ucfirst($towing->status) }}
                            </span>
                        </td>
                        <td>{{ number_format($towing->price, 2) }}</td>
                        <td>{{ $towing->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
