<?php

namespace App\Http\Controllers\Worker;

use App\Models\Worker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class WorkerController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:App\Models\Worker,username',
            'email' => 'required|email|unique:App\Models\Worker,email',
            'password' => 'required',
            'gender' => 'required',
            'phone_number' => 'required|unique:App\Models\Worker,phone_number',
            'born_date' => 'required'
        ]);

        $worker = Worker::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'born_date' => $request->born_date,
            'role' => 'worker'
        ]);

        if ($worker) {
            return response()->json([
                'success' => true,
                'message' => 'Successful registration',
                'data' => $worker,
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

        $worker = Worker::where('email', $request->email)->first();
        $credentials = request(['email', 'password']);
        if (! $token = auth()->guard('worker')->attempt($credentials)) {
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
                    'email' => $worker->email,
                    'username' => $worker->username,
                    'phone_number' => $worker->phone_number,
                ],
                'role' => $worker->role,
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
        $worker = auth()->user();
        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' => [
                'username' => $worker->username,
                'email' => $worker->email,
                'gender' => $worker->gender,
                'phone_number' => $worker->phone_number,
                'address' => $worker->address,
                'born_date' => $worker->born_date,
                'role' => $worker->role,
            ]
        ]);
    }
}
