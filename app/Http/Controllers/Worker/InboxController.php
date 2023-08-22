<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Inbox\InboxResource;
use App\Models\Inbox;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index() {
        $worker = auth()->user();
        
        return response()->json([
            'success' => true,
            'message' => 'Get my inbox',
            'data' => InboxResource::collection($worker->inbox->sortBy('created_at')),
        ]);
    }
    
    public function read(int $id) {
        $worker = auth()->user();
        $inbox = $worker->inbox->find($id);

        if (is_null($inbox)) {
            return HttpStatus::code404('Data not found');
        }

        $inbox->read = AppFunction::booleanRequest(true);
        $inbox->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Read inbox',
            'data' => new InboxResource($inbox),
        ]);
    }
}
