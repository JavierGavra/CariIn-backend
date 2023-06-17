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
    // Create Job
    public function create(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'location' => 'required|string',
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
            'location' => $request->location,
            'time_type' => $request->time_type,
            'salary' => $request->salary,
            'company_id' => $company->id,
            'gender' => $request->gender,
            'education' => $request->education,
            'minimum_age' => $request->minimum_age,
            'maximum_age' => $request->maximum_age,
            'description' => $request->description,
            'pkl_status' => AppFunction::booleanRequest($request->pkl_status),
            'confirmed_status' => 'menunggu'
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

    // Job list
    public function index(Request $request) {
        $confirmed_status = $request->query('confirmed_status');
        $company = auth()->user();
        
        if (isset($confirmed_status)) {
            if ($confirmed_status == 'diterima' or $confirmed_status == 'ditolak' or $confirmed_status == 'menunggu'){
                $job = JobListResource::collection($company->jobs->where('confirmed_status', $confirmed_status));
            } else {
                return redirect()->route('bad-filter');
            }
        } else {
            $job = JobListResource::collection($company->jobs);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get my job data',
            'data' => $job,
        ]);
    }
    
    // Detail
    public function show(int $id) {
        $company = auth()->user();
        $job = $company->jobs->find($id);

        if (is_null($job)) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => [],
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new JobDetailResource($job),
            ]);
        }
    }

    // Delete all rejected job
    public function deleteAllDitolak() {
        $company = auth()->user();
        Job::where('company_id', $company->id)->where('confirmed_status', 'ditolak')->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully deleted all data',
            'data' => [],
        ]);
    }

    // Delete job by ID
    public function deleteById(int $id) {
        $company = auth()->user();
        $job = $company->jobs->find($id);

        if (is_null($job)) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => [],
            ], 404);
        } else {
            $job->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted data',
                'data' => [],
            ]);
        }
    }
}
