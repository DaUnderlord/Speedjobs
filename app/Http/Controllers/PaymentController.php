<?php

namespace App\Http\Controllers;

use App\Models\CourseEnrollment;
use App\Models\Payment;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        
        if (!$reference) {
            return redirect()->route('home')->with('error', 'No payment reference provided.');
        }

        try {
            $response = $this->paystackService->verifyPayment($reference);
            $payment = Payment::where('transaction_reference', $reference)->firstOrFail();

            if ($payment->status === 'completed') {
                return $this->redirectSuccess($payment);
            }

            DB::beginTransaction();

            $this->paystackService->updatePaymentStatus($payment, $response);

            if ($payment->status === 'completed') {
                // Handle successful payment based on type
                if ($payment->course_id) {
                    $this->handleCourseEnrollment($payment);
                } elseif ($payment->counselor_booking_id) {
                    // Handle counselor booking confirmation
                    // $this->handleCounselorBooking($payment);
                }
            }

            DB::commit();

            if ($payment->status === 'completed') {
                return $this->redirectSuccess($payment);
            }

            return redirect()->route('home')->with('error', 'Payment verification failed.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Verification Error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred during payment verification.');
        }
    }

    protected function handleCourseEnrollment(Payment $payment)
    {
        CourseEnrollment::firstOrCreate(
            [
                'user_id' => $payment->user_id,
                'course_id' => $payment->course_id,
            ],
            [
                'payment_id' => $payment->id,
                'status' => 'enrolled',
                'enrolled_at' => now(),
            ]
        );

        $payment->course->increment('enrollment_count');
    }

    protected function redirectSuccess(Payment $payment)
    {
        if ($payment->course_id) {
            return redirect()->route('courses.show', $payment->course_id)
                ->with('success', 'Payment successful! You are now enrolled.');
        }

        return redirect()->route('home')->with('success', 'Payment successful!');
    }
}
