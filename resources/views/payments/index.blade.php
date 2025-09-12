@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">M-Pesa Payments</h2>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ===================== --}}
    {{-- Towing Requests Table --}}
    {{-- ===================== --}}
    <h4>Towing Requests</h4>
    @if($towings->isEmpty())
        <p>No towing requests available.</p>
    @else
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pickup</th>
                    <th>Destination</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($towings as $towing)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $towing->pickup_location }}</td>
                    <td>{{ $towing->destination }}</td>
                    <td>KES {{ number_format($towing->price, 2) }}</td>
                    <td>{{ ucfirst($towing->status) }}</td>
                    <td>{{ ucfirst($towing->payment_status ?? 'Unpaid') }}</td>
                    <td>
                        @if(strtolower($towing->status) == 'completed' && strtolower($towing->payment_status) != 'paid')
                            <form method="POST" action="{{ route('payment.initiate', $towing->id) }}" class="d-flex gap-2">
                                @csrf
                                <input type="text" name="phone" class="form-control form-control-sm"
                                       placeholder="2547XXXXXXXX" value="{{ $towing->phone }}" required>
                                <button type="submit" class="btn btn-success btn-sm">Pay Now</button>
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

    {{-- ===================== --}}
    {{-- Past Transactions --}}
    {{-- ===================== --}}
    <h4>Past Transactions</h4>
    @if($transactions->isEmpty())
        <p>No transactions available.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Phone</th>
                    <th>Amount (KES)</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->MSISDN }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>
                        <span class="badge
                            @if(strtolower($transaction->status) == 'success') bg-success
                            @elseif(strtolower($transaction->status) == 'pending') bg-warning
                            @else bg-danger
                            @endif">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>{{ $transaction->created_at->format('d M Y, h:i A') }}</td>
                    <td>{{ $transaction->mpesaReceiptNumber ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
