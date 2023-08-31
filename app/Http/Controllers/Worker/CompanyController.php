<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company\CompanyDetailResource;
use App\Http\Resources\Company\CompanyListResource;
use App\Http\Resources\DeviceToken\DeviceTokenResource;
use App\Models\Company;
use App\Models\Inbox;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index() {
        $companies = Company::where('confirmed_status', 'diterima')->get();

        return response()->json([
            'success' => true,
            'message' => 'Get all company',
            'data' => CompanyListResource::collection($companies)
        ]);
    }
    
    public function show(int $id) {
        $company = Company::where('confirmed_status', 'diterima')->find($id);
        
        if (is_null($company)) {
            return HttpStatus::code404("Data not found");
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Get all company',
                'data' => new CompanyDetailResource($company)
            ]);
        }
    }
    
    public function getDeviceToken(int $id) {
        $company = Company::where('confirmed_status', 'diterima')->find($id);
        
        if (is_null($company)) {
            return HttpStatus::code404('Data not found');
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Get company device token',
                'data' => new DeviceTokenResource($company)
            ]);
        }
    }

    public function sendInbox(Request $request, int $id) {
        $company = Company::find($id);

        if (is_null($company)) {
            return HttpStatus::code404("Data not found");
        }
        
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'type' => 'nullable',
            'redirect_id' => 'nullable',
        ]);

        $inbox = new Inbox();
        $inbox->subject = $request->subject;
        $inbox->message = $request->message;
        $inbox->type = is_null($request->type)? 'sistem' : $request->type;
        $inbox->redirect_id = $request->redirect_id;
        $company->inbox()->save($inbox);

        return response()->json([
            'success' => true,
            'message' => 'Inbox sent successfully',
            'data' => [],
        ], 201);
    }
}
