<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenController extends Controller
{
    public function refreshToken(Request $request)
    {
        $user = Auth::guard($request->role)->user();
        $newToken = JWTAuth::refresh(JWTAuth::getToken());

        if ($request->role == 'admin' || $request->role == 'worker') {
            return response()->json([
                'success' => true,
                'message' => 'Successfully refresh token',
                'data' => [
                    'user' => [
                        'email' => $user->email,
                        'username' => $user->username,
                    ],
                    'role' => $user->role,
                    'token' => $newToken,
                ]
            ]);
        } elseif ($request->role == 'company') {
            return response()->json([
                'success' => true,
                'message' => 'Successfully refresh token',
                'data' => [
                    'user' => [
                        'email' => $user->email,
                        'name' => $user->name,
                    ],
                    'role' => $user->role,
                    'token' => $newToken,
                ]
            ]);
        }
    }
}
