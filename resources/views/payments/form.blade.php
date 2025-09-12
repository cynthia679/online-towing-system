@extends('layouts.app')

@section('title', 'Pay for Towing')

@section('content')
<div class="container mt-5">
    <h2>Pay for Towing Request #{{ $towing->id }}</h2>
    <p><strong>Pickup:</strong> {{ $towing->pickup_location }}</p>
    <p><strong>Destination:</strong> {{ $towing->destination }}</p>
    <p><strong>Amount:</strong> KES {{ number_format($towing->price, 2) }}</p>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('payment.initiate', $towing->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="2547XXXXXXXX"
                   value="{{ $towing->phone }}" required>
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Pay with M-Pesa</button>
        <a href="{{ route('towing.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection
