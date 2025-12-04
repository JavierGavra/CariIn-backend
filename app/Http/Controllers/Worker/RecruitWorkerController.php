<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecruitWorker\worker\RecruitWorkerDetailResource;
use App\Http\Resources\RecruitWorker\worker\RecruitWorkerListResource;
use App\Models\JobApplication;
use App\Models\RecruitWorker;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecruitWorkerController extends Controller
{
    public function index(Request $request) {
        $worker = auth()->user();
        $recruitWorkers = $worker->recruitWorkers;
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
        $worker = auth()->user();
        $recruitWorker = $worker->recruitWorkers->find($id);
        
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
    
    public function sendReply(int $id, Request $request) {
        $worker = auth()->user();
        $recruitWorker = $worker->recruitWorkers
        ->where('reply_status', 'menunggu')
        ->find($id);
        if (is_null($recruitWorker)) {
            return HttpStatus::code404('Data not found');
        }

        $request->validate([
            'worker_message' => 'nullable',
            'reply_status' => ['required', Rule::in(['diterima', 'ditolak']),],
        ]);

        $recruitWorker->worker_message = $request->worker_message;
        $recruitWorker->reply_status = $request->reply_status;
        $recruitWorker->save();

        return response()->json([
            'success' => true,
            'message' => 'Your reply has been send',
            'data' => $recruitWorker,
        ]);
    }
}
