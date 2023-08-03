<?php

namespace App\Http\Controllers\Company;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobApplication\company\JobApplicationListResource;
use App\Http\Resources\JobApplication\JobApplicationDetailResource;
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
    
    public function defineConfirmation(Request $request, int $id) {
        $company = auth()->user();
        $jobApplication = JobApplication::whereIn('job_id', $company->jobs->pluck('id'))
        ->where('confirmed_status', 'menunggu')
        ->find($id);
        if (is_null($jobApplication)) {
            return HttpStatus::code404('Data not found');  
        }

        $confirmedStatusValidate = ['diterima', 'ditolak']; 
        $request->validate(['confirmed_status' => 'required']);
        if(!in_array($request->confirmed_status, $confirmedStatusValidate)) {
            return HttpStatus::code400();
        }

        $jobApplication->confirmed_status = $request->confirmed_status;
        $jobApplication->save();

        return response()->json([
            'success' => true,
            'message' => 'Changes saved successfully',
            'data' => new JobApplicationDetailResource($jobApplication),
        ]);
    }
}