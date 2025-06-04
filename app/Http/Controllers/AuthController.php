<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        if ($user->role !== $request->role) {
            return back()->withErrors(['role' => 'Role tidak sesuai dengan akun ini.']);
        }

        Auth::login($user);

        switch ($user->role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'manajer':
                return redirect('/manajer/dashboard');
            case 'staff':
                return redirect('/staff/dashboard');
            default:
                Auth::logout();
                return redirect('/login')->withErrors(['role' => 'Role tidak dikenali.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
