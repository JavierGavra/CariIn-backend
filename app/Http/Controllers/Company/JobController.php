<?php

namespace App\Http\Controllers\Company;

use App\Models\Job;
use App\Helpers\AppFunction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company\JobListResource;
use App\Http\Resources\Company\JobDetailResource;
use Illuminate\Http\Request;

class JobController extends Controller
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
            'description' =>'required',
            'pkl_status' => 'required'
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
            'description' => $request->description,
            'pkl_status' => AppFunction::booleanRequest($request->pkl_status),
            'confirmed_status' => 'waiting'
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
        $job = JobListResource::collection($company->jobs);
        return response()->json([
            'success' => true,
            'message' => 'Get all my job data',
            'data' => $job,
        ]);
    }

    public function acceptedList()
    {
        $company = auth()->user();
        $job = JobListResource::collection($company->jobs->where('confirmed_status', 'accept'));
        return response()->json([
            'success' => true,
            'message' => 'Get all my job (accept) data',
            'data' => $job,
        ]);
    }
    
    public function rejectedList()
    {
        $company = auth()->user();
        $job = JobListResource::collection($company->jobs->where('confirmed_status', 'reject'));
        return response()->json([
            'success' => true,
            'message' => 'Get all my job (reject) data',
            'data' => $job,
        ]);
    }
    
    public function show(int $id)
    {
        $company = auth()->user();
        $job = $company->jobs->find($id);
        if ($job == null) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => [],
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' => new JobDetailResource($job),
        ]);
    }
}
