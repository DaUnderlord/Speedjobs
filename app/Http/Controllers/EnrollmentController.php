<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    public function enroll(Request $request, Course $course)
    {
        $user = Auth::user();

        if ($course->isEnrolledBy($user->id)) {
            return redirect()->route('courses.show', $course)->with('info', 'You are already enrolled in this course.');
        }

        if ($course->is_free) {
            CourseEnrollment::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'status' => 'enrolled',
                'enrolled_at' => now(),
            ]);

            $course->increment('enrollment_count');

            return redirect()->route('courses.show', $course)->with('success', 'Successfully enrolled in course!');
        }

        // Handle paid course enrollment
        try {
            $reference = $this->paystackService->generateReference();
            
            // Create pending payment record
            $payment = $this->paystackService->createPaymentRecord([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'amount' => $course->price,
                'currency' => 'NGN', // Assuming NGN for now
                'reference' => $reference,
            ]);

            // Initialize Paystack transaction
            $data = [
                'email' => $user->email,
                'amount' => $course->price,
                'reference' => $reference,
                'callback_url' => route('payment.callback'),
                'metadata' => [
                    'payment_id' => $payment->id,
                    'type' => 'course_enrollment',
                    'course_id' => $course->id,
                ],
            ];

            $response = $this->paystackService->initializePayment($data);

            if ($response['status']) {
                return redirect($response['data']['authorization_url']);
            }

            return back()->with('error', 'Unable to initialize payment: ' . $response['message']);

        } catch (\Exception $e) {
            return back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    public function myCourses()
    {
        $enrollments = Auth::user()->enrollments()->with('course')->latest()->paginate(10);
        return view('courses.my-courses', compact('enrollments'));
    }
}
