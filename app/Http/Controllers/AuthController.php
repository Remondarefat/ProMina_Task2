<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    // User login
    public function userRegisterForm()
    {
        return view('user.register');
    }
    public function userRegister(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'mobile' => 'required|string|max:20|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'password' => Hash::make($request->password),
    ]);

    // Log in the user
    Auth::login($user);

    // Redirect the user to the login form after successful registration
    return redirect()->route('user.login');
}

    public function userLoginForm()
    {
        return view('user.login');
    }

    public function userLogin(Request $request)
    {
        // Validate the login request data
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::guard('web')->attempt($credentials)) {
            // Authentication successful for user
            return view('index');
        } else {
            // Authentication failed
            return redirect()->route('user.login')->with('error', 'Invalid email or password');
        }
    }

    // Admin login
    public function adminLoginForm()
    {
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        // Validate the login request data
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the admin
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication successful for admin
            return redirect()->route('admin.dashboard');
        }else {
            // Authentication failed
            return redirect()->route('admin.login')->with('error', 'Invalid email or password');
        }
    }
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }
}
