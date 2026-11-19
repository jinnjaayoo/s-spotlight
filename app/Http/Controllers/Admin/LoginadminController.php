<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginadminController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dasbor');
        }

        return view('admin.loginadmin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',      //Validation//
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {         //auth proses login
            $request->session()->regenerate();

            return redirect()
                ->intended(route('admin.dasbor'))
                ->with('toast_success', 'Login berhasil. Selamat datang di dashboard admin.');
        }

        return back()
            ->withErrors(['email' => 'Email atau password yang Anda masukkan salah.'])
            ->with('toast_error', 'Email atau password yang Anda masukkan salah.')
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();         // proses logout

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
