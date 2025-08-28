@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="card shadow-lg p-4 rounded-3">
        <h2 class="text-success fw-bold">✅ Payment Successful</h2>
        <p class="mt-3">Thank you for your payment. Your transaction was completed successfully.</p>

        <a href="{{ route('client.dashboard') }}" class="btn btn-primary mt-4">Go to Dashboard</a>
    </div>
</div>
@endsection
