<?php

namespace App\Http\Controllers\Worker;

use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Http\Resources\Job\JobListResource;
use App\Http\Resources\Job\JobDetailResource;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $job = JobListResource::collection(Job::all()->where('confirmed_status', 'diterima'));
        return response()->json([
            'success' => true,
            'message' => 'Get all job data',
            'data' => $job,
        ]);
    }
    
    public function show(int $id)
    {
        $job = Job::all()->where('confirmed_status', 'accept')->find($id);
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
}
