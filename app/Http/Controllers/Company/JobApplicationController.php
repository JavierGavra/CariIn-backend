<?php

namespace App\Http\Controllers\Company;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobApplication\company\JobApplicationListResource;
use App\Http\Resources\JobApplication\JobApplicationDetailResource;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request) {
        $confirmed_status = $request->query('confirmed_status');
        $company = auth()->user();
        $jobApplications = JobApplication::whereIn('job_id', $company->jobs->pluck('id'))->get();

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
        $company = auth()->user();
        $jobApplication = JobApplication::whereIn('job_id', $company->jobs->pluck('id'))->find($id);

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
}