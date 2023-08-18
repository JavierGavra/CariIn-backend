<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceToken\DeviceTokenResource;
use App\Models\Company;

class CompanyController extends Controller
{
    public function getDeviceToken(int $id) {
        $company = Company::find($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Get company device token',
            'data' => new DeviceTokenResource($company)
        ]);
    }
}
