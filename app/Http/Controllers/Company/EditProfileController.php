<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceToken\DeviceTokenResource;
use App\Models\Company;
use App\Models\CompanyDeviceToken;
use Illuminate\Http\Request;

class EditProfileController extends Controller
{
    //* ##### Device token #####
    public function getDeviceToken() {
        $company = auth()->user();

        return response()->json([
            'success' => true,
            'message' => "Get device token",
            'data' => new DeviceTokenResource($company),
        ]);
    }
    
    public function setDeviceToken(Request $request) {
        $request->validate(['device_token' => 'required']);
        $company = Company::find(auth()->user()->id);

        if (is_null($company->deviceToken)) {
            CompanyDeviceToken::create([
                'company_id' => $company->id,
                'token' => $request->device_token,
            ]);
        } else {
            $deviceToken = $company->deviceToken;
            $deviceToken->token = $request->device_token;
            $deviceToken->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => "Successful change device token",
            'data' => [],
        ]);
    }
}
