<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Company;

class CompanyController extends Controller
{
    public function getDeviceToken(int $id) {
        $deviceToken = Company::find($id)->deviceToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Get company device token',
            'data' => ['device_token' => $deviceToken->token]
        ]);
    }
}
