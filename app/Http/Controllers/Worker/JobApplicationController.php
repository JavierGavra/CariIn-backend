<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index() {
        $jobApplications = JobApplication::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Get all job apllications data',
            'data' => [],
        ]);
    }
    
    public function show(int $id) {
        $jobApplication = JobApplication::find($id);

        if (is_null($jobApplication)) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => [],
            ]);   
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => $jobApplication,
            ]);
        }
    }

    public function create(Request $request) {
        $request->validate([
            ''
        ]);
    }
}
