<?php

namespace App\Http\Controllers\Worker;

use App\Models\Job;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobWorkerController extends Controller
{
    public function all()
    {
        $job = Job::all();
        return response()->json([
            'success' => true,
            'message' => 'Get all job data',
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
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' => $job,
        ]);
    }
}
