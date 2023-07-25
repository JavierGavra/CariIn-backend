<?php

namespace App\Http\Controllers\Admin_web;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index() {
        if (auth()->guard('admin')->check()) {
            return redirect('/dashboard');
        }

        return view('admin.auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:App\Models\Admin,username',
            'email' => 'required|email|unique:App\Models\Admin,email',
            'password' => 'required',
            'gender' => 'required'
        ]);

        $admin = Admin::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'role' => 'admin'
        ]);

        if ($admin) {
            return response()->json([
                'success' => true,
                'message' => 'Successful registration',
                'data' => $admin,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'data' => [],
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email:dns',
            'password'=>'required'
        ]);

        if (auth()->guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/test');
        }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout() 
    {
        auth()->guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function me()
    {
        $admin = auth()->user();
        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' => [
                'username' => $admin->username,
                'email' => $admin->email,
                'gender' => $admin->gender,
                'role' => $admin->role,
            ]
        ]);
    }
}
