<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenController extends Controller
{
    public function refreshToken()
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json([
            'success' => true,
            'message' => 'Successfully refresh token',
            'data' => [
                'token' => $newToken,
            ]
        ]);
    }
}

