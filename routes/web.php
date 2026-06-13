<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\EventCategoryController;

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

    Route::get('/', fn() => redirect()->route('dashboard'));
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

});