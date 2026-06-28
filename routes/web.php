<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\EventOrganizerController;
use App\Http\Controllers\EventRoleController;
use App\Http\Controllers\EventTicketController;
use App\Http\Controllers\EventStaffController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\FrontendController;

// ── Frontend Customer ────────────────────────────────────────────────────────
Route::get('/', [FrontendController::class, 'home'])->name('front.home');
Route::get('/event/{slug}', [FrontendController::class, 'show'])->name('front.events.show');
Route::get('/event/{slug}/checkout', [FrontendController::class, 'checkout'])->name('front.checkout');

// ── Auth (guest) ──────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', fn() => back()->with('status', 'Link dikirim!'))->name('password.email');
Route::get('/reset-password/{token?}', fn($token = '') => view('auth.reset-password', compact('token')))->name('password.reset');
Route::post('/reset-password', fn() => redirect()->route('login'))->name('password.update');
Route::get('/otp-verification', fn() => view('auth.otp-verification'))->name('otp.verification');

// ── Protected ─────────────────────────────────────────────────────────────────
Route::middleware(['auth.custom', 'auto.logout'])->group(function () {

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::post('/keep-alive', function () {
        session(['last_activity' => now()->timestamp]);
        return response()->json(['status' => 'ok']);
    })->name('keep.alive');

    // ── Superadmin only ───────────────────────────────────────────────────────
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('menus', MenuController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('users', UserController::class);
    });

    // ── Event Categories ──────────────────────────────────────────────────────
    Route::resource('event_categories', EventCategoryController::class);
    Route::resource('events', EventController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('attendees', AttendeeController::class);
    Route::resource('event_organizers', EventOrganizerController::class);
    Route::resource('event_roles', EventRoleController::class);
    Route::resource('event_tickets', EventTicketController::class);
    Route::resource('event_staffs', EventStaffController::class);
    Route::resource('order_items', OrderItemController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('checkins', CheckinController::class);

});
