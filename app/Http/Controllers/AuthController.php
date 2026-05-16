<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.'
        ]);


        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();

            $user = Auth::user();

          
            if ($user->role == 'admin') {
                return redirect()->route('dashboard')
                    ->with('success', 'Welcome Admin!');
            }

            if ($user->role == 'employee') {
                return redirect()->route('employee.dashboard')
                    ->with('success', 'Welcome Employee!');
            }
        }

        return back()->with('error', 'Invalid Email or Password.');
    }


    public function dashboard(\Illuminate\Http\Request $request)
    {
        $employeeCount = \App\Models\Employee::count();
        $departmentCount = \App\Models\Department::count();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard', compact('employeeCount', 'departmentCount'))->render()
            ]);
        }
        return view('dashboard', compact('employeeCount', 'departmentCount'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
