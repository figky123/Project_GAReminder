<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Coba untuk login
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Menyimpan role pengguna dalam variabel
        $role = $user->role;

        // Mengarahkan ke halaman dashboard jika berhasil dengan pesan selamat datang
        return redirect()->intended('penerbangan')->with('welcome_message', 'Selamat Datang, ' . $user->name . '. Anda masuk sebagai ' . $role);
    }

    // Jika gagal login
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->withInput();
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
