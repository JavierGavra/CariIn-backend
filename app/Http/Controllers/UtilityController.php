<?php

namespace App\Http\Controllers;

use App\Http\Resources\UnauthenticatedResource;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    public function helloWorld()
    {
        return response()->json([
            'success' => true,
            'message' => "Hello, World!",
            'data' => [],
        ], 200);
    }
    
    public function unauthenticated()
    {
        return response()->json([
            'success' => false,
            'message' => "Unauthenticated",
            'data' => [],
        ], 401);
    }
    
    public function badFilter()
    {
        return response()->json([
            'success' => false,
            'message' => "Filter not found",
            'data' => [],
        ], 400);
    }
}
