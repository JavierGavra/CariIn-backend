<?php

namespace App\Http\Controllers\Company;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecruitWorker\RecruitWorkerDetailResource;
use App\Http\Resources\RecruitWorker\RecruitWorkerListResource;
use App\Models\Job;
use App\Models\RecruitWorker;
use Illuminate\Http\Request;

class RecruitWorkerController extends Controller
{
    public function index(Request $request) {
        $company = auth()->user();
        $recruitWorkers = RecruitWorker::whereIn('job_id', $company->jobs->pluck('id'))->get();
        $reply_status = $request->query('reply_status');
        
        $replyStatusValidate = ['menunggu', 'diterima', 'ditolak'];
        
        if (isset($reply_status)) {
            if (in_array($reply_status, $replyStatusValidate)) {
                $recruitWorkers = $recruitWorkers->where('reply_status', $reply_status);
            } else {
                return redirect()->route('bad-filter');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Get recruit list',
            'data' => RecruitWorkerListResource::collection($recruitWorkers),
        ]);
    }
    
    public function show(int $id) {
        $company = auth()->user();
        $recruitWorker = RecruitWorker::whereIn('job_id', $company->jobs->pluck('id'))->find($id);

        if (is_null($recruitWorker)) {
            return HttpStatus::code404('Data not found');  
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new RecruitWorkerDetailResource($recruitWorker),
            ]);
        }
    }

    public function create(Request $request) {
        $request->validate([
            'worker_id' => 'required|exists:workers,id',
            'job_id' => 'required',
            'description' => 'required',
        ]);
        $job = Job::findOrFail($request->job_id);

        if ($job->confirmed_status == 'ditolak') {
            return HttpStatus::code422('This job is not verified by the admin');
        }   
        if (RecruitWorker::where('worker_id', $request->worker_id)->get()->contains('job_id', $request->job_id)) {
            return HttpStatus::code409('This Job has send for this user');
        }
        $recruitWorker = RecruitWorker::create([
            'worker_id' => $request->worker_id,
            'job_id' => $request->job_id,
            'description' => $request->description,
            'reply_status' => 'menunggu'
        ]);

        if ($recruitWorker) {
            return response()->json([
                'success' => true,
                'message' => 'Recruit added successfully',
                'data' => $recruitWorker,
            ], 201);
        } else {
            return HttpStatus::code400('Job application failed to add');
        }
    }
}