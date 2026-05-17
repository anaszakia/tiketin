<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Opsional: kalau sudah login langsung ke dashboard
        if (session('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('frontend.home');
    }
}