@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="card shadow-lg p-4 rounded-3">
        <h2 class="text-danger fw-bold">❌ Payment Failed</h2>
        <p class="mt-3">Unfortunately, your payment could not be processed. Please try again.</p>

        <a href="{{ route('payment.initiate') }}" class="btn btn-warning mt-4">Retry Payment</a>
    </div>
</div>
@endsection
