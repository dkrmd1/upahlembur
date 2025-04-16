<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request) {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // Coba autentikasi
        if (Auth::attempt($credentials, $request->has('remember'))) {
            // Regenerasi session ID untuk mencegah session fixation
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek role user
            toast()->success('Hallo', 'Selamat Datang ' . $user->name);
            return redirect()->intended('/');
        }

        // Autentikasi gagal
        toast()->error('Gagal', 'Email atau password salah.');
        return back()->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toast()->success('Berhasil', 'Berhasil anda telah logout');
        return redirect('/')->withInput();
    }
}
