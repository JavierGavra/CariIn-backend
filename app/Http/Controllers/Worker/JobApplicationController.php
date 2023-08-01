<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobApplication\JobApplicationDetailResource;
use App\Http\Resources\JobApplication\worker\JobApplicationListResource;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request) {
        $confirmed_status = $request->query('confirmed_status');
        $worker = auth()->user();
        $jobApplications = JobApplication::where('worker_id', $worker->id)->get();

        $confirmedStatusValidate = ['diterima', 'ditolak', 'menunggu'];
        
        if (isset($confirmed_status)) {
            if (in_array($confirmed_status, $confirmedStatusValidate)){
                $jobApplications = $jobApplications->where('confirmed_status', $confirmed_status);
            } else {
                return redirect()->route('bad-filter');
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Get all job apllications data',
            'data' => JobApplicationListResource::collection($jobApplications),
        ]);
    }
    
    public function show(int $id) {
        $worker = auth()->user();
        $jobApplication = JobApplication::where('worker_id', $worker->id)->get()->find($id);

        if (is_null($jobApplication)) {
            return HttpStatus::code404('Data not found');  
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new JobApplicationDetailResource($jobApplication),
            ]);
        }
    }

    public function create(Request $request) {
        $request->validate([
            'job_id' => 'required|integer',
            'description' => 'required',
        ]);
        $worker = auth()->user();
        $job = Job::findOrFail($request->job_id);

        if ($job->confirmed_status == 'ditolak') {
            return HttpStatus::code422('This job is not accepted by the admin');
        }   
        if ($worker->jobApplications->contains('job_id', $request->job_id)) {
            return HttpStatus::code409('Job application already exist for this user');
        }
        $jobApplication = JobApplication::create([
            'job_id' => $request->job_id,
            'worker_id' => $worker->id,
            'description' => $request->description,
            'confirmed_status' => 'menunggu',
        ]);

        if ($jobApplication) {
            return response()->json([
                'success' => true,
                'message' => 'Job application added successfully, waiting response from company',
                'data' => $jobApplication,
            ], 201);
        } else {
            return HttpStatus::code400('Job application failed to add');
        }
    }
}
