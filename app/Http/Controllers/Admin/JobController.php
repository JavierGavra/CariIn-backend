<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\JobListResource;
use App\Http\Resources\Admin\JobDetailResource;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function all()
    {
        $job = JobListResource::collection(Job::all());
        return response()->json([
            'success' => true,
            'message' => 'Get all my job data',
            'data' => $job,
        ]);
    }
    
    public function acceptedList()
    {
        $job = JobListResource::collection(Job::where('confirmed_status', 'accept')->get());
        return response()->json([
            'success' => true,
            'message' => 'Get all my job (accept) data',
            'data' => $job,
        ]);
    }
    
    public function rejectedList()
    {
        $job = JobListResource::collection(Job::where('confirmed_status', 'reject')->get());
        return response()->json([
            'success' => true,
            'message' => 'Get all my job (reject) data',
            'data' => $job,
        ]);
    }
    
    public function waitingList()
    {
        $job = JobListResource::collection(Job::where('confirmed_status', 'waiting')->get());
        return response()->json([
            'success' => true,
            'message' => 'Get all job (waiting) data',
            'data' => $job,
        ]);
    }

    public function show(int $id)
    {
        $job = Job::find($id);
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

    public function defineConfirmation(Request $request, int $id)
    {
        $job = Job::where('confirmed_status', 'waiting')->find($id);
        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => [],
            ], 404);
        }

        $request->validate(['confirmed_status' => 'required']);
        $job->confirmed_status = $request->confirmed_status;
        $job->save();

        return response()->json([
            'success' => true,
            'message' => 'Changes saved successfully',
            'data' => new JobDetailResource($job),
        ]);
    }
}
