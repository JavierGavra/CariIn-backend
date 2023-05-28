<?php

namespace App\Http\Controllers\Company;

use App\Models\Job;
use App\Http\Controllers\Controller;
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

        $job = Job::create([
            'title' => $request->title,
            'city' => $request->city,
            'time_type' => $request->time_type,
            'salary' => $request->salary,
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
}
