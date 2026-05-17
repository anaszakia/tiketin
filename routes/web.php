<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Frontend\HomeController;

// =============================================
// PUBLIC ROUTES (tanpa middleware)
// =============================================
Route::get('/', [HomeController::class, 'index'])->name('home');  // ← pindah ke sini

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', fn() => back()->with('status', 'Link dikirim!'))->name('password.email');
Route::get('/reset-password/{token?}', fn($token = '') => view('auth.reset-password', compact('token')))->name('password.reset');
Route::post('/reset-password', fn() => redirect()->route('login'))->name('password.update');
Route::get('/otp-verification', fn() => view('auth.otp-verification'))->name('otp.verification');

// =============================================
// PROTECTED ROUTES (harus login)
// =============================================
Route::middleware(['auth.custom', 'auto.logout'])->group(function () {
    // ← hapus Route::get('/') yang lama dari sini
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('/menus', MenuController::class);
        Route::resource('/roles', RoleController::class);
        Route::resource('/permissions', PermissionController::class);
    });

    Route::post('/keep-alive', function () {
        session(['last_activity' => now()->timestamp]);
        return response()->json(['status' => 'ok']);
    })->name('keep.alive');

    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:users.view');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('permission:users.create');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:users.view');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:users.edit');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:users.delete');
});