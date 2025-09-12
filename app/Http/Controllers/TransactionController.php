<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Towing;

class TransactionController extends Controller
{
    // Show all transactions and towings for payment
    public function index()
    {
        $transactions = Transaction::orderByDesc('id')->get();
        $towings = Towing::all();
        return view('payments.index', compact('transactions', 'towings'));
    }

    // Show payment form for a single towing
    public function showPaymentForm($towingId)
    {
        $towing = Towing::find($towingId);

        if (!$towing) {
            return redirect()->route('payment.index')->with('error', 'Towing request not found.');
        }

        return view('payments.form', compact('towing'));
    }

    // Mock payment for school project
    public function pay(Request $request, Towing $towing)
    {
        // Only allow payment if completed
        if ($towing->status !== 'completed') {
            return redirect()->route('towing.index')->with('error', 'Cannot pay before towing is completed.');
        }

        // Check if already paid
        if ($towing->payment_status === 'Paid') {
            return redirect()->route('towing.index')->with('info', 'This request is already paid.');
        }

        // Mock transaction creation
        $transaction = Transaction::create([
            'MSISDN' => $request->phone ?? '254700000000',
            'accountNumber' => 'TowingService',
            'amount' => $towing->price,
            'status' => 'Success', // Always success for mock
            'transactionType' => 'Mock Payment',
            'dateCreated' => now(),
            'dateModified' => now(),
            'towing_id' => $towing->id,
        ]);

        // Update towing as paid
        $towing->payment_status = 'Paid';
        $towing->save();

        return redirect()->route('towing.index')->with('success', 'Payment completed successfully (mock).');
    }

    // Success page
    public function success()
    {
        return view('payments.success');
    }

    // Failed page
    public function failed()
    {
        return view('payments.failed');
    }
}
