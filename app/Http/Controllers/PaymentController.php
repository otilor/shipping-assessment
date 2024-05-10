<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // Initiate a payment
    public function initiate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|between:0,99999.99',
        ]);

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'status' => 'pending',
            // Normally we would also interact with a payment gateway here
        ]);

        // Simulate transaction ID assignment from payment gateway
        $payment->transaction_id = collect(['paystack', 'flutterwave', 'fincra'])->random() . '_' . Str::random(16);
        $payment->save();

        return response()->json([
            'message' => 'Payment initiated successfully!',
            'payment' => $payment,
        ], 201);
    }

    // Enquire about a payment status
    public function enquiry($paymentId)
    {
        $payment = Payment::where('id', $paymentId)->where('user_id', Auth::id())->firstOrFail();

        return response()->json([
            'payment' => $payment,
        ], 200);
    }
}
