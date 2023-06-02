<?php

namespace App\Http\Controllers\Company;

use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company\JobListResource;
use Illuminate\Http\Request;

class JobCompanyController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'city' => 'required|string',
            'time_type' => 'required',
            'salary' => 'required',
            'gender' => 'required',
            'education' => 'required',
            'minimum_age' => 'required',
            'maximum_age' => 'nullable',
            'description' =>'required'
        ]);

        $company = auth()->user();
        $job = Job::create([
            'title' => $request->title,
            'city' => $request->city,
            'time_type' => $request->time_type,
            'salary' => $request->salary,
            'company_id' => $company->id,
            'gender' => $request->gender,
            'education' => $request->education,
            'minimum_age' => $request->minimum_age,
            'maximum_age' => $request->maximum_age,
            'description' => $request->description
        ]);
        if ($job) {
            return response()->json([
                'success' => true,
                'message' => 'Job added successfully, Waiting for admin confirmation',
                'data' => $job,
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Job failed to add',
                'data' => [],
            ]);
        }
    }

    public function all()
    {
        $company = auth()->user();
        $job = JobListResource::collection(Job::where('company_id', $company->id)->get());
        return response()->json([
            'success' => true,
            'message' => 'Get all my job data',
            'data' => $job,
        ]);
    }
}
