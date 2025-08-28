@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">M-Pesa Payments</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Show past transactions --}}
    <h4>Past Transactions</h4>
    @if(isset($transactions) && $transactions->isEmpty())
        <p>No transactions available.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Phone</th>
                    <th>Pickup</th>
                    <th>Destination</th>
                    <th>Amount (KES)</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions ?? [] as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->phone }}</td>
                    <td>{{ $transaction->pickup }}</td>
                    <td>{{ $transaction->destination }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>
                        <span class="badge
                            @if($transaction->status == 'success') bg-success
                            @elseif($transaction->status == 'pending') bg-warning
                            @else bg-danger
                            @endif">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>
                        @if($transaction->status == 'pending')
                        <form method="POST" action="{{ route('payment.initiate', $transaction->towing_id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Pay with M-Pesa</button>
                        </form>
                        @else
                            —
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
