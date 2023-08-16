<?php

namespace App\Http\Controllers\Company;

use App\Helpers\AppFunction;
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
            'name' => 'required|unique:App\Models\Company,name',
            'email' => 'required|email|unique:App\Models\Company,email',
            'password' => 'required',
            'field' => 'required',
        ]);
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'field' => $request->field,
            'employees' => 0,
            'confirmed_status' => 'menunggu',
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
                    'name' => $company->name,
                ],
                'role' => $company->role,
                'token' => $token
            ]
        ]);
    }

    public function fillData(Request $request)
    {
        $company = Company::find(auth()->user()->id);
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'founding_date' => 'required',
            'user_type' => 'required',
            'location' => 'required',
            'description' => 'required',
            'outside_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'inside_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $profileImagePath = 'images/company/profile';
        $outsideImagePath ='images/company/outside';
        $insideImagePath ='images/company/inside';
        $profileImageName = AppFunction::getImageName($request->file('profile_image'));
        $outsideImageName = AppFunction::getImageName($request->file('outside_image'));
        $insideImageName = AppFunction::getImageName($request->file('inside_image'));

        $company->profile_image = $profileImagePath.'/'.$profileImageName;
        $company->founding_date = $request->founding_date;
        $company->user_type = $request->user_type;
        $company->location = $request->location;
        $company->description = $request->description;
        $company->outside_image = $outsideImagePath.'/'.$outsideImageName;
        $company->inside_image = $insideImagePath.'/'.$insideImageName;
        $company->save();

        $request->file('profile_image')->storeAs($profileImagePath, $profileImageName);
        $request->file('outside_image')->storeAs($outsideImagePath, $outsideImageName);
        $request->file('inside_image')->storeAs($insideImagePath, $insideImageName);

        if ($company) {
            return response()->json([
                'success' => true,
                'message' => 'Successful fill data',
                'data' => $company,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'failed fill data',
                'data' => [],
            ]);
        }
    }

    public function me()
    {
        $company = auth()->user();
        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' => $company
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
