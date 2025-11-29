<?php

namespace App\Http\Controllers;

use App\Models\Counselor;
use App\Models\CounselorBooking;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    public function store(Request $request, Counselor $counselor)
    {
        $request->validate([
            'session_date' => 'required|date|after:today',
            'session_time' => 'required',
            'session_type' => 'required|in:virtual,in-person',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $amount = $counselor->hourly_rate;

        try {
            $reference = $this->paystackService->generateReference();

            // Create pending booking
            $booking = CounselorBooking::create([
                'user_id' => $user->id,
                'counselor_id' => $counselor->id,
                'session_date' => $request->session_date,
                'session_time' => $request->session_time,
                'duration_minutes' => 60, // Default to 1 hour
                'session_type' => $request->session_type,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Create pending payment record
            $payment = $this->paystackService->createPaymentRecord([
                'user_id' => $user->id,
                'counselor_booking_id' => $booking->id,
                'amount' => $amount,
                'currency' => 'NGN',
                'reference' => $reference,
            ]);

            // Update booking with payment ID
            $booking->update(['payment_id' => $payment->id]);

            // Initialize Paystack transaction
            $data = [
                'email' => $user->email,
                'amount' => $amount,
                'reference' => $reference,
                'callback_url' => route('payment.callback'),
                'metadata' => [
                    'payment_id' => $payment->id,
                    'type' => 'counselor_booking',
                    'booking_id' => $booking->id,
                ],
            ];

            $response = $this->paystackService->initializePayment($data);

            if ($response['status']) {
                return redirect($response['data']['authorization_url']);
            }

            return back()->with('error', 'Unable to initialize payment: ' . $response['message']);

        } catch (\Exception $e) {
            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }

    public function myBookings()
    {
        $bookings = Auth::user()->counselorBookings()
            ->with(['counselor.user', 'payment'])
            ->latest()
            ->paginate(10);

        return view('counselors.my-bookings', compact('bookings'));
    }
}
