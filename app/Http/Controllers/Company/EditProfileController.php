<?php

namespace App\Http\Controllers\Company;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceToken\DeviceTokenResource;
use App\Models\Company;
use App\Models\CompanyDeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    //* ##### Edit profile #####
    public function editProfile(Request $request) {
        $company = Company::find(auth()->user()->id);
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'description' => 'required',
            'user_type' => 'required',
            'url' => 'nullable',
        ]);

        $company->name = $request->name;
        $company->location = $request->location;
        $company->description = $request->description;
        $company->user_type = $request->user_type;
        $company->url = $request->url;
        $company->save();

        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Successful edit data',
                'data' => $company,
            ], 201);
        } else {
            return HttpStatus::code400('Failed edit data');
        }
    }

    //* ##### Profile Image #####
    public function getProfileImage() {
        $company = auth()->user();
        return response()->json([
            'success' => true,
            'message' => "Get profile image",
            'data' => ['profile_image' => $company->profile_image],
        ]);
    }
    
    public function setProfileImage(Request $request) {
        $request->validate(['profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        $company = Company::find(auth()->user()->id);
        
        if (isset($company->profile_image)) {
            Storage::delete($company->profile_image);
        }

        $profileImagePath ='images/company/profile';
        $profileImageName = AppFunction::getImageName($request->file('profile_image'));
        $company->profile_image = $profileImagePath.'/'.$profileImageName;
        $request->file('profile_image')->storeAs($profileImagePath, $profileImageName);
        $company->save();
        
        return response()->json([
            'success' => true,
            'message' => "successful change profile image",
            'data' => [],
        ]);
    }
    
    //* ##### Inside Image #####
    public function getInsideImage() {
        $company = auth()->user();
        return response()->json([
            'success' => true,
            'message' => "Get inside image",
            'data' => ['inside_image' => $company->inside_image],
        ]);
    }
    
    public function setInsideImage(Request $request) {
        $request->validate(['inside_image' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        $company = Company::find(auth()->user()->id);
        
        if (isset($company->inside_image)) {
            Storage::delete($company->inside_image);
        }

        $insideImagePath ='images/company/inside';
        $insideImageName = AppFunction::getImageName($request->file('inside_image'));
        $company->inside_image = $insideImagePath.'/'.$insideImageName;
        $request->file('inside_image')->storeAs($insideImagePath, $insideImageName);
        $company->save();
        
        return response()->json([
            'success' => true,
            'message' => "successful change inside image",
            'data' => [],
        ]);
    }
    
    //* ##### Outside Image #####
    public function getOutsideImage() {
        $company = auth()->user();
        return response()->json([
            'success' => true,
            'message' => "Get outside image",
            'data' => ['outside_image' => $company->outside_image],
        ]);
    }
    
    public function setOutsideImage(Request $request) {
        $request->validate(['outside_image' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
        $company = Company::find(auth()->user()->id);
        
        if (isset($company->outside_image)) {
            Storage::delete($company->outside_image);
        }

        $outsideImagePath ='images/company/outside';
        $outsideImageName = AppFunction::getImageName($request->file('outside_image'));
        $company->outside_image = $outsideImagePath.'/'.$outsideImageName;
        $request->file('outside_image')->storeAs($outsideImagePath, $outsideImageName);
        $company->save();
        
        return response()->json([
            'success' => true,
            'message' => "successful change outside image",
            'data' => [],
        ]);
    }

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
