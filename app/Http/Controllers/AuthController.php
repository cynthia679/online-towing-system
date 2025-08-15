<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ===== CLIENT LOGIN & REGISTER =====
    public function showClientLogin()
    {
        return view('auth.login-client');
    }

    public function showClientRegister()
    {
        return view('auth.register-client');
    }

    public function registerClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
        ]);

        Auth::login($user);

        return redirect()->route('client.dashboard')->with('success', 'Account created successfully!');
    }

    public function loginClient(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->role !== 'client') {
                Auth::logout();
                return back()->withErrors(['email' => 'Invalid client credentials.']);
            }

            $request->session()->regenerate();
            return redirect()->route('client.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid client credentials.']);
    }

    // ===== ADMIN LOGIN =====
    public function showAdminLogin()
    {
        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Invalid admin credentials.']);
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid admin credentials.']);
    }

    // ===== DRIVER LOGIN =====
    public function showDriverLogin()
    {
        return view('auth.login-driver');
    }

    public function loginDriver(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->role !== 'driver') {
                Auth::logout();
                return back()->withErrors(['email' => 'Invalid driver credentials.']);
            }

            $request->session()->regenerate();
            return redirect()->route('driver.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid driver credentials.']);
    }

    // ===== LOGOUT =====
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
