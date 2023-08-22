<?php

namespace App\Http\Controllers\Company;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Inbox\InboxResource;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index() {
        $company = auth()->user();
        
        return response()->json([
            'success' => true,
            'message' => 'Get my inbox',
            'data' => InboxResource::collection($company->inbox->sortBy('created_at')),
        ]);
    }
    
    public function read(int $id) {
        $company = auth()->user();
        $inbox = $company->inbox->find($id);

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
