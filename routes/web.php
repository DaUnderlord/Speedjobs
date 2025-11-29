<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $banners = \App\Models\Banner::active()->get();
    return view('welcome', compact('banners'));
})->name('welcome');

Route::get('/dashboard', [\App\Http\Controllers\JobseekerDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employer Routes
    Route::get('/employer/dashboard', [\App\Http\Controllers\EmployerDashboardController::class, 'index'])->name('employer.dashboard');

    // Resume Builder
    Route::get('/resume/create', [ResumeController::class, 'create'])->name('resume.create');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('banners', \App\Http\Controllers\AdminBannerController::class);
});

// Public Job Routes
Route::resource('jobs', \App\Http\Controllers\JobController::class)->only(['index', 'show', 'create', 'store']);

// Course Routes (Moved to Gated Section)

// Authenticated Course Routes
Route::middleware('auth')->group(function () {
    Route::post('/courses/{course}/enroll', [\App\Http\Controllers\EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::get('/my-courses', [\App\Http\Controllers\EnrollmentController::class, 'myCourses'])->name('courses.my-courses');
    Route::get('/courses/{course:slug}/learn/{lesson:slug?}', [\App\Http\Controllers\LessonController::class, 'show'])->name('courses.learn');

    // Counselor Routes
    Route::get('/counselors', [\App\Http\Controllers\CounselorController::class, 'index'])->name('counselors.index');
    Route::get('/counselors/{counselor}', [\App\Http\Controllers\CounselorController::class, 'show'])->name('counselors.show');
    Route::post('/counselors/{counselor}/book', [\App\Http\Controllers\BookingController::class, 'store'])->name('counselors.book');
    Route::get('/my-bookings', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('counselors.my-bookings');

    // Career Planning
    Route::get('/career-planning', [\App\Http\Controllers\CareerPlanningController::class, 'index'])->name('career-planning.index');
    Route::post('/career-planning', [\App\Http\Controllers\CareerPlanningController::class, 'store'])->name('career-planning.store');

    // Counseling Requests (User)
    Route::get('/counseling', [\App\Http\Controllers\CounselingRequestController::class, 'index'])->name('counseling.index');
    Route::get('/counseling/apply', [\App\Http\Controllers\CounselingRequestController::class, 'create'])->name('counseling.create');
    Route::post('/counseling', [\App\Http\Controllers\CounselingRequestController::class, 'store'])->name('counseling.store');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('banners', \App\Http\Controllers\AdminBannerController::class);
    Route::resource('resources', \App\Http\Controllers\Admin\ResourceController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Counseling Requests (Admin)
    Route::get('/counseling', [\App\Http\Controllers\Admin\CounselingRequestController::class, 'index'])->name('counseling.index');
    Route::get('/counseling/{counselingRequest}', [\App\Http\Controllers\Admin\CounselingRequestController::class, 'show'])->name('counseling.show');
    Route::post('/counseling/{counselingRequest}/assign', [\App\Http\Controllers\Admin\CounselingRequestController::class, 'assign'])->name('counseling.assign');
});

// Payment Routes
Route::get('/payment/callback', [\App\Http\Controllers\PaymentController::class, 'callback'])->name('payment.callback');


// Career Services & Skill Up (Public pages with feature-level gating)
Route::middleware('auth')->group(function () {
    Route::view('/career-services', 'career-services')->name('career-services');
    Route::view('/skill-up', 'skill-up')->name('skill-up');
    Route::view('/career-advice', 'career-advice')->name('career-advice');
    Route::view('/skill-assessments', 'skill-assessments')->name('skill-assessments');
});

// Course Routes (Public access, enrollment gated)
Route::get('/courses', [\App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [\App\Http\Controllers\CourseController::class, 'show'])->name('courses.show');

Route::view('/browse-candidates', 'browse-candidates')->name('browse-candidates');

Route::view('/about', 'about')->name('about');

require __DIR__.'/auth.php';
