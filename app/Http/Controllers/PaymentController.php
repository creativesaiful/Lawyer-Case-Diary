<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use ItsRafsanJani\Bkash\Facades\Bkash;
use ItsRafsanJani\Bkash\Data\CreatePaymentData;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiate()
    {
        return view('payments.bkash');
    }

    public function createPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'user_id' => 'required|integer'
        ]);

        $amount = $request->input('amount');
        $user_id = $request->input('user_id');
        $invoiceId = uniqid('inv_');

        $payment = Payment::create([
            'user_id' => $user_id,
            'amount' => $amount,
            'method' => 'bkash',
            'status' => 'pending',
            'transaction_id' => $invoiceId
        ]);

        try {
            $response = Bkash::createPayment(
                new CreatePaymentData(
                    amount: $amount,
                    payerReference: $invoiceId,
                    callbackURL: route('bkash.callback')
                )
            );
            
            $payment->update(['payload' => $response->original]);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Bkash Payment Creation Failed: ' . $e->getMessage());
            $payment->update(['status' => 'failed']);
            return response()->json(['error' => 'Payment creation failed. Please try again.'], 500);
        }
    }

    public function callback(Request $request)
    {
        $paymentID = $request->query('paymentID');
        $status = $request->query('status');

        if ($status === 'success') {
            try {
                $response = Bkash::executePayment($paymentID);

                if ($response->isSuccess()) {
                    $trxID = $response->getTrxID();
                    $merchantInvoice = $response->getMerchantInvoice();

                    $payment = Payment::where('transaction_id', $merchantInvoice)->first();

                    if ($payment) {
                        $payment->update([
                            'status' => 'success',
                            'payload' => $response->original,
                            'transaction_id' => $trxID
                        ]);
                        // Optional: approve the user here
                        // $user = $payment->user;
                        // $user->approved = true;
                        // $user->save();
                    }
                    return redirect()->route('login')->with('success', 'Payment successful! Please wait for admin approval.');
                }
            } catch (\Exception $e) {
                Log::error('Bkash Payment Execution Failed: ' . $e->getMessage());
                // Handle failure
                return redirect()->route('login')->with('error', 'Payment failed. Please contact support.');
            }
        }
        
        return redirect()->route('login')->with('error', 'Payment was not successful. Please try again.');
    }
}