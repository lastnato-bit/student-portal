<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use App\Http\Controllers\Student\GradeReportController as StudentGradeReportController;

// ✅ Livewire Student Components
use App\Livewire\Student\{Dashboard, Grades, Schedule, Profile, ActivityLogs, GradeReport, Holidays};

// ✅ Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminForcePasswordChangeController;
use App\Http\Controllers\Auth\SuperadminResetController;
use App\Http\Controllers\Auth\AdminResetController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Livewire\Superadmin\RegisterSuperadmin;
use App\Http\Controllers\Auth\StudentSecureResetController;
use App\Http\Controllers\StudentCalendarController;
use App\Http\Controllers\AdminCalendarController;
use App\Http\Controllers\Admin\GradeReportController;
use App\Http\Controllers\Student\GradeController;
use App\Http\Controllers\AnnouncementController;
use App\Livewire\Student\Concerns;
use App\Models\ClassSchedule;
use App\Livewire\Superadmin\VerifyOtp;
use App\Livewire\Auth\SuperadminLogin;

// ✅ Landing Page
Route::get('/', fn() => view('landing'))->name('landing');

// ✅ Guest Routes
Route::middleware('guest')->group(function () {
    // ✅ Custom Login Pages
    Route::get('/login/admin', \App\Livewire\Auth\AdminLogin::class)->name('login.admin');
    Route::get('/login/superadmin', \App\Livewire\Auth\SuperadminLogin::class)->name('login.superadmin');
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/login', \App\Livewire\Auth\StudentLogin::class)->name('login');

    // ✅ Student Forgot Password (Fortify)
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
    Route::get('/login/superadmin', SuperadminLogin::class)->name('superadmin.login');

    // ✅ Superadmin Forgot Password (OTP Only)
    Route::get('/superadmin/forgot-password', [SuperadminResetController::class, 'showRequestForm'])->name('superadmin.password.request');
    Route::post('/superadmin/forgot-password', [SuperadminResetController::class, 'sendResetLinkEmail'])->name('superadmin.password.email');

    Route::get('/superadmin/verify-otp/{id}', [OtpVerificationController::class, 'showOtpForm'])->name('superadmin.verify-otp.form');
    Route::post('/superadmin/verify-otp/{id}', [OtpVerificationController::class, 'verifyOtp'])->name('superadmin.verify-otp.verify');

    Route::get('/superadmin/verify-otp/{id}', VerifyOtp::class)->name('superadmin.verify-otp.form');

    Route::get('/superadmin/reset-password', [SuperadminResetController::class, 'showResetForm'])->name('superadmin.reset.form');
    Route::post('/superadmin/reset-password', [SuperadminResetController::class, 'submitReset'])->name('superadmin.reset.submit');

    // ✅ Admin Forgot Password (OTP-based)
    Route::get('/admin/forgot-password', [AdminResetController::class, 'showRequestForm'])->name('admin.password.request');
    Route::post('/admin/forgot-password', [AdminResetController::class, 'sendResetLinkEmail'])->name('admin.password.email');

    Route::get('/admin/verify-otp/{id}', [OtpVerificationController::class, 'showAdminOtpForm'])->name('admin.verify-otp.form');
    Route::post('/admin/verify-otp/{id}', [OtpVerificationController::class, 'verifyAdminOtp'])->name('admin.verify-otp.verify');

    Route::get('/admin/reset-password', [AdminResetController::class, 'showResetForm'])->name('admin.reset.form');
    Route::post('/admin/reset-password', [AdminResetController::class, 'submitReset'])->name('admin.reset.submit');

    // ✅ Secure Student Forgot Password (custom)
    Route::get('/forgot-password', [StudentSecureResetController::class, 'showRequestForm'])->name('password.request');
    Route::post('/forgot-password', [StudentSecureResetController::class, 'handleResetRequest'])->name('student.password.email');

    Route::resource('announcements', AnnouncementController::class);
});

// ✅ Profile Page (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'show'])->name('profile.show');
});

// ✅ Logout Routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('web')->name('logout');

Route::get('/superadmin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('superadmin.logout');

Route::get('/admin/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('admin.logout');

// Admin Calendar
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/calendar', [AdminCalendarController::class, 'showForm'])->name('admin.calendar');
    Route::post('/admin/calendar', [AdminCalendarController::class, 'store'])->name('admin.calendar.store');
});

// ✅ Admin PDF Grade Report Export
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/grades/{student}/pdf', [GradeReportController::class, 'export'])
        ->name('admin.grades.pdf');
});

// Student Calendar
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/calendar', [StudentCalendarController::class, 'index'])->name('student.calendar');
});

// ✅ Admin Force Password Change
Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::get('/force-password-change', [AdminForcePasswordChangeController::class, 'showForm'])->name('admin.force-password-change');
    Route::post('/force-password-change', [AdminForcePasswordChangeController::class, 'update'])->name('admin.force-password-change.update');
});

// ✅ Authenticated Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->hasRole('superadmin')) return redirect('/superadmin');
        if ($user->hasRole('admin')) return redirect('/admin');
        if ($user->hasRole('student')) return redirect()->route('student.dashboard');
        abort(403, 'Unauthorized role.');
    })->name('dashboard');

    // ✅ Student Routes
    Route::prefix('student')->name('student.')->middleware(['role:student'])->group(function () {
        Route::get('/dashboard', function () { return view('livewire.student.dashboard'); })->name('dashboard');
        Route::get('/grades', Grades::class)->name('grades');
        Route::get('/schedule', Schedule::class)->name('schedule');
        Route::get('/profile', Profile::class)->name('profile');
        Route::get('/activity-logs', ActivityLogs::class)->name('activity-logs');
        Route::get('/grades/report', GradeReport::class)->name('grades.report');
        Route::get('/holidays', Holidays::class)->name('holidays');
        Route::get('/announcements', function () {
            $announcements = \App\Models\Announcement::whereIn('visible_to', ['student', 'all'])
                ->orderByDesc('published_at')
                ->get();
            return view('livewire.student.announcements', compact('announcements'));
        })->name('announcements');

        Route::get('/enrollment-info', function () {
            return view('livewire.student.enrollment-info');
        })->name('enrollment-info');

        // ✅ Grade PDF Export (for admin)
        Route::get('/grades/pdf', [StudentGradeReportController::class, 'export'])->name('grades.pdf');

        // ✅ Grade Report Download Button (PDF) — NEWLY ADDED
        Route::get('/grades/download', [GradeController::class, 'download'])->name('download-grades');

        // ✅ FIXED: Concern Submission Page (moved to correct place)
        Route::get('/concerns', Concerns::class)->name('concerns');
    });

    // ✅ Superadmin Routes (Requires 2FA)
    Route::middleware(['role:superadmin', \App\Http\Middleware\Ensure2FAIsEnabled::class])->group(function () {
        Route::get('/superadmin/register', RegisterSuperadmin::class)->name('superadmin.register');
    });

    // ✅ Debug Only
    Route::get('/debug-auth', fn() => ['isLoggedIn' => Auth::check(), 'user' => Auth::user()]);

    // ✅ Shortcut to 2FA Setup
    Route::get('/user/two-factor-authentication', fn() => redirect()->route('profile.show') . '#two-factor-authentication')->name('two-factor.setup');
});

//use App\Http\Controllers\HolidayController;

//Route::middleware(['auth', 'role:admin|superadmin'])->prefix('admin')->group(function () {
    //Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');
    //Route::get('/holidays/create', [HolidayController::class, 'create'])->name('holidays.create');
    //Route::post('/holidays', [HolidayController::class, 'store'])->name('holidays.store');
//});

// ✅ Google Calendar Test Route
use App\Services\GoogleCalendarService;

Route::get('/test-calendar', function (GoogleCalendarService $calendar) {
    $event = $calendar->createEvent(
        '📅 Test Laravel Event',
        'This is a test event created from Laravel.',
        now()->addHour(),
        now()->addHours(2)
    );

    return "Event created: <a href='{$event->htmlLink}' target='_blank'>View in Google Calendar</a>";
});
