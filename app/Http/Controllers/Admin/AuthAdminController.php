<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthAdminController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:App\Models\Worker,username',
            'email' => 'required|email|unique:App\Models\Worker,email',
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();
        $credentials = request(['email', 'password']);
        if (! $token = auth()->guard('admin')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'data' => []
            ], 401);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Successful login',
            'data' => [
                'user' => [
                    'email' => $admin->email,
                    'username' => $admin->username,
                ],
                'role' => $admin->role,
                'token' => $token
            ]
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success' => true,
            'message' => 'User logout successfully',
            'data' => []
        ]);
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
