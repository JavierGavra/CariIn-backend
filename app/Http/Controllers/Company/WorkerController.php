<?php

namespace App\Http\Controllers\Company;

use App\Helpers\AppFunction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Worker\WorkerDetailResource;
use App\Http\Resources\Worker\WorkerListResource;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index() {
        $workers = Worker::where('company_visible', 1)->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get workers list',
            'data' => WorkerListResource::collection($workers),
        ]);
    }

    public function show(int $id) {
        $workers = Worker::where('company_visible', 1)->find($id);

        if (is_null($workers)) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found',
                'data' => [],
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new WorkerDetailResource($workers),
            ]);
        }
        
    }
}
