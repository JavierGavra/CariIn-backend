<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HttpStatus;
use App\Models\Job;
use App\Http\Controllers\Controller;
use App\Http\Resources\Job\JobListResource;
use App\Http\Resources\Job\JobDetailResource;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // Job list
    public function index(Request $request) {
        $confirmed_status = $request->query('confirmed_status');
        $jobs = Job::all();

        $confirmedStatusValidate = ['belum_terverifikasi', 'terverifikasi', 'ditolak'];

        if (isset($confirmed_status)) {
            if (in_array($confirmed_status, $confirmedStatusValidate)){
                $jobs = $jobs->where('confirmed_status', $confirmed_status);
            } else {
                return redirect()->route('bad-filter');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Get all my job data',
            'data' => JobListResource::collection($jobs),
        ]);
    }

    // Detail
    public function show(int $id) {
        $job = Job::find($id);
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

    // Define confirmation of job
    public function defineConfirmation(Request $request, int $id) {
        $job = Job::find($id);
        if (is_null($job)) {
            return HttpStatus::code404('Data not found');
        }

        $request->validate(['confirmed_status' => 'required']);
        $job->confirmed_status = $request->confirmed_status;
        $job->save();

        return response()->json([
            'success' => true,
            'message' => 'Changes saved successfully',
            'data' => new JobListResource($job),
        ]);
    }

    // Delete all rejected job
    public function deleteAllDitolak() {
        Job::where('confirmed_status', 'ditolak')->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully deleted all data',
            'data' => [],
        ]);
    }

    // Delete job by ID
    public function deleteById(int $id) {
        $job = Job::find($id);
        if (is_null($job)) {
            return HttpStatus::code404('Data not found');
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
