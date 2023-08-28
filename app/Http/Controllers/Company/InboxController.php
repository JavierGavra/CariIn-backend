<?php

namespace App\Http\Controllers\Company;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Inbox\InboxResource;
use App\Models\Company;
use App\Models\Inbox;
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

    public function create(Request $request) {
        $company = Company::find(auth()->user()->id);

        if (is_null($company)) {
            return HttpStatus::code404("Data not found");
        }
        
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);

        $inbox = new Inbox();
        $inbox->subject = $request->subject;
        $inbox->message = $request->message;
        $company->inbox()->save($inbox);

        return response()->json([
            'success' => true,
            'message' => 'Inbox sent successfully',
            'data' => [],
        ], 201);
    }
}
