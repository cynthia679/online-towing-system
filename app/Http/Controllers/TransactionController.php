<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use App\Models\Towing;

class TransactionController extends Controller
{
    // Show all transactions and towings for payment
    public function index()
    {
        $transactions = Transaction::orderBy('id', 'desc')->get();
        $towings = Towing::all(); // Fetch all towings
        return view('payments.index', compact('transactions', 'towings'));
    }

    // Show payment form for a single towing (optional)
    public function showPaymentForm($towingId)
    {
        $towing = Towing::find($towingId);

        if (!$towing) {
            return redirect()->route('payment.index')->with('error', 'Towing request not found.');
        }

        return view('payments.form', compact('towing'));
    }


    // Initiate M-Pesa STK Push
    public function initiateMpesa(Request $request, Towing $towing)
    {
        $phone = $request->input('phone');
        $amount = $towing->price ?? $request->input('amount', 1);

        // Get access token
        $consumerKey = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');

        $tokenResponse = Http::withBasicAuth($consumerKey, $consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        $accessToken = $tokenResponse['access_token'];

        $timestamp = date('YmdHis');
        $shortCode = env('MPESA_SHORTCODE');
        $passkey = env('MPESA_PASSKEY');
        $password = base64_encode($shortCode . $passkey . $timestamp);

        $stkResponse = Http::withToken($accessToken)
            ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
                "BusinessShortCode" => $shortCode,
                "Password" => $password,
                "Timestamp" => $timestamp,
                "TransactionType" => "CustomerPayBillOnline",
                "Amount" => $amount,
                "PartyA" => $phone,
                "PartyB" => $shortCode,
                "PhoneNumber" => $phone,
                "CallBackURL" => env('MPESA_CALLBACK_URL'),
                "AccountReference" => "TowingService",
                "TransactionDesc" => "Payment for towing"
            ]);

        $responseBody = $stkResponse->json();

        Transaction::create([
            'MSISDN'             => $phone,
            'accountNumber'      => 'TowingService',
            'amount'             => $amount,
            'merchantRequestID'  => $responseBody['MerchantRequestID'] ?? null,
            'checkoutRequestID'  => $responseBody['CheckoutRequestID'] ?? null,
            'resultCode'         => $responseBody['ResponseCode'] ?? null,
            'resultDesc'         => $responseBody['ResponseDescription'] ?? null,
            'status'             => 'Pending',
            'businessShortCode'  => $shortCode,
            'transactionType'    => 'STK Push',
            'dateCreated'        => now(),
            'dateModified'       => now(),
        ]);

        return response()->json($responseBody);
    }

    // M-Pesa Callback
    public function mpesaCallback(Request $request)
    {
        $data = $request->all();
        \Log::info('M-Pesa Callback:', $data);

        if (isset($data['Body']['stkCallback'])) {
            $callback = $data['Body']['stkCallback'];

            Transaction::where('checkoutRequestID', $callback['CheckoutRequestID'])
                ->update([
                    'mpesaReceiptNumber' => $callback['CallbackMetadata']['Item'][1]['Value'] ?? null,
                    'transactionDate'    => $callback['CallbackMetadata']['Item'][3]['Value'] ?? null,
                    'resultCode'         => $callback['ResultCode'],
                    'resultDesc'         => $callback['ResultDesc'],
                    'status'             => $callback['ResultCode'] == 0 ? 'Success' : 'Failed',
                    'dateModified'       => now(),
                ]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
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

    // Check transaction status by ID
    public function status($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json([
            'transaction_id'      => $transaction->id,
            'phone'               => $transaction->MSISDN,
            'amount'              => $transaction->amount,
            'status'              => $transaction->status,
            'mpesaReceiptNumber'  => $transaction->mpesaReceiptNumber,
            'transactionDate'     => $transaction->transactionDate,
            'resultDesc'          => $transaction->resultDesc,
        ]);
    }
}
