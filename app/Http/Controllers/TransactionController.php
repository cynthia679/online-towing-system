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
        $transactions = Transaction::orderByDesc('id')->get();
        $towings = Towing::all();

        return view('payments.index', compact('transactions', 'towings'));
    }

    // Show payment form for a single towing
    public function showPaymentForm($towingId)
    {
        $towing = Towing::find($towingId);

        if (!$towing) {
            return redirect()
                ->route('payment.index')
                ->with('error', 'Towing request not found.');
        }

        return view('payments.form', compact('towing'));
    }

    /**
     * Initiate M-Pesa STK Push
     */
    public function initiateMpesa(Request $request, $towingId)
    {
        $towing = Towing::find($towingId);

        if (!$towing) {
            return redirect()
                ->route('payment.index')
                ->with('error', 'Towing request not found.');
        }

        if ($towing->status !== 'completed') {
            return redirect()
                ->route('payment.form', $towingId)
                ->with('error', 'Cannot pay before towing is completed.');
        }

        if ($towing->payment_status === 'Paid') {
            return redirect()
                ->route('towing.index')
                ->with('info', 'This towing request is already paid.');
        }

        // Get phone number from the payment form
        $phone = preg_replace('/\D/', '', $request->phone);

        // Convert 07XXXXXXXX to 2547XXXXXXXX
        if (strlen($phone) === 10 && substr($phone, 0, 2) === '07') {
            $phone = '254' . substr($phone, 1);
        }

        // Convert 01XXXXXXXX to 2541XXXXXXXX
        if (strlen($phone) === 10 && substr($phone, 0, 2) === '01') {
            $phone = '254' . substr($phone, 1);
        }

        if (strlen($phone) !== 12 || substr($phone, 0, 3) !== '254') {
            return back()->with('error', 'Please enter a valid Kenyan phone number.');
        }

        // Get Daraja access token
        $credentials = base64_encode(
            env('MPESA_CONSUMER_KEY') . ':' . env('MPESA_CONSUMER_SECRET')
        );

        $tokenResponse = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->get(
            'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        );

        if (!$tokenResponse->successful()) {
            return back()->with(
                'error',
                'Unable to connect to M-Pesa. Please try again.'
            );
        }

        $accessToken = $tokenResponse->json('access_token');

        // STK Push timestamp
        $timestamp = now()->format('YmdHis');

        // Generate password
        $password = base64_encode(
            env('MPESA_SHORTCODE') .
            env('MPESA_PASSKEY') .
            $timestamp
        );

        // Send STK Push
        $stkResponse = Http::withToken($accessToken)
            ->post(
                'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest',
                [
                    'BusinessShortCode' => env('MPESA_SHORTCODE'),
                    'Password' => $password,
                    'Timestamp' => $timestamp,
                    'TransactionType' => 'CustomerPayBillOnline',
                    'Amount' => (int) round($towing->price),
                    'PartyA' => $phone,
                    'PartyB' => env('MPESA_SHORTCODE'),
                    'PhoneNumber' => $phone,
                    'CallBackURL' => env('MPESA_CALLBACK_URL'),
                    'AccountReference' => 'TOWING-' . $towing->id,
                    'TransactionDesc' => 'Vehicle Towing Payment',
                ]
            );

        $result = $stkResponse->json();

        if (!$stkResponse->successful()) {
            return back()->with(
                'error',
                'M-Pesa STK Push failed. Please try again.'
            );
        }

        // Save pending transaction
        Transaction::create([
            'MSISDN' => $phone,
            'accountNumber' => 'TOWING-' . $towing->id,
            'amount' => $towing->price,
            'status' => 'Pending',
            'transactionType' => 'STK Push',
            'merchantRequestID' => $result['MerchantRequestID'] ?? null,
            'checkoutRequestID' => $result['CheckoutRequestID'] ?? null,
            'resultCode' => $result['ResponseCode'] ?? null,
            'resultDesc' => $result['ResponseDescription'] ?? null,
            'dateCreated' => now(),
            'dateModified' => now(),
            'towing_id' => $towing->id,
        ]);

        if (($result['ResponseCode'] ?? null) === '0') {
            return back()->with(
                'success',
                'STK Push sent successfully. Check your phone and enter your M-Pesa PIN.'
            );
        }

        return back()->with(
            'error',
            $result['ResponseDescription'] ?? 'M-Pesa request failed.'
        );
    }

    /**
     * Receive Safaricom STK Push callback
     */
    public function mpesaCallback(Request $request)
    {
        $data = $request->all();

        $callback = $data['Body']['stkCallback'] ?? null;

        if (!$callback) {
            return response()->json([
                'ResultCode' => 1,
                'ResultDesc' => 'Invalid callback data'
            ]);
        }

        $checkoutRequestID = $callback['CheckoutRequestID'] ?? null;
        $resultCode = $callback['ResultCode'] ?? null;
        $resultDesc = $callback['ResultDesc'] ?? null;

        $transaction = Transaction::where(
            'checkoutRequestID',
            $checkoutRequestID
        )->first();

        if (!$transaction) {
            return response()->json([
                'ResultCode' => 0,
                'ResultDesc' => 'Callback received'
            ]);
        }

        $transaction->resultCode = $resultCode;
        $transaction->resultDesc = $resultDesc;
        $transaction->dateModified = now();

        // Successful payment
        if ((string) $resultCode === '0') {

            $items = $callback['CallbackMetadata']['Item'] ?? [];

            $metadata = [];

            foreach ($items as $item) {
                if (isset($item['Name'])) {
                    $metadata[$item['Name']] = $item['Value'] ?? null;
                }
            }

            $transaction->status = 'Success';

            $transaction->mpesaReceiptNumber =
                $metadata['MpesaReceiptNumber'] ?? null;

            $transaction->transactionDate =
                $metadata['TransactionDate'] ?? null;

            $transaction->MSISDN =
                $metadata['PhoneNumber'] ?? $transaction->MSISDN;

            $transaction->amount =
                $metadata['Amount'] ?? $transaction->amount;

            $transaction->save();

            // Mark towing as paid
            $towing = Towing::find($transaction->towing_id);

            if ($towing && $towing->payment_status !== 'Paid') {
                $towing->payment_status = 'Paid';
                $towing->save();
            }

        } else {
            // Failed/cancelled payment
            $transaction->status = 'Failed';
            $transaction->save();
        }

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Callback processed successfully'
        ]);
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
