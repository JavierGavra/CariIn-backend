<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function amount() {
        $workersAmount = Worker::all()->count();
        
        return response()->json([
            'success' => true,
            'message' => 'Get workers amount',
            'data' => ['amount' => $workersAmount],
        ]);
    }
}
