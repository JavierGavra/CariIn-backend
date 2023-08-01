<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\HttpStatus;
use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Http\Resources\Job\JobListResource;
use App\Http\Resources\Job\JobDetailResource;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::whereNotIn('confirmed_status', ['ditolak'])->get();
        $confirmed_status = $request->query('confirmed_status');

        $confirmedStatusValidate = ['belum_terverifikasi', 'terverifikasi'];

        if (isset($confirmed_status)) {
            if (in_array($confirmed_status, $confirmedStatusValidate)) {
                $jobs = $jobs->where('confirmed_status', $confirmed_status);
            } else {
                return redirect()->route('bad-filter');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Get all job data',
            'data' => JobListResource::collection($jobs),
        ]);
    }
    
    public function show(int $id)
    {
        $job = Job::all()->whereNotIn('confirmed_status', ['ditolak'])->find($id);
        if (is_null($job)) {
            return HttpStatus::code404('Data not found');
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new JobDetailResource($job),
            ]);
        }
    }
}
