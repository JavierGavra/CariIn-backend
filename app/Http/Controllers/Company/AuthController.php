<?php

namespace App\Http\Controllers\Company;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:App\Models\Company,username',
            'email' => 'required|email|unique:App\Models\Company,email',
            'password' => 'required',
            'category' => 'required',
            'founding_date' => 'required',
            'user_type' => 'required',
            'location' => 'required',
            'description' => 'required'
        ]);

        $company = Company::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'category' => $request->category,
            'founding_date' => $request->founding_date,
            'user_type' => $request->user_type,
            'location' => $request->location,
            'description' => $request->description,
            'employees' => 0,
            'role' => 'company'
        ]);

        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Successful registration',
                'data' => $company,
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
            'email' => 'required',
            'password' => 'required'
        ]);

        $company = Company::where('email', $request->email)->first();
        $credentials = request(['email', 'password']);
        if (! $token = auth()->guard('company')->attempt($credentials)) {
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
                    'email' => $company->email,
                    'username' => $company->username,
                ],
                'role' => $company->role,
                'token' => $token
            ]
        ]);
    }

    public function me()
    {
        $company = auth()->user();
        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' => [
                'username' => $company->username,
                'email' => $company->email,
                'category' => $company->category,
                'founding_date' => $company->founding_date,
                'user_type' => $company->user_type,
                'location' => $company->location,
                'description' => $company->description,
                'employees' => $company->employees,
                'role' => $company->role
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
}
