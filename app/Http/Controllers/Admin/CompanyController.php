<?php

namespace App\Http\Controllers\Admin;

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
    public function index(Request $request) {
        $companies = Company::all();
        $confirmed_status = $request->query('confirmed_status');
        $field = $request->query('field');
        
        $confirmedStatusValidate = ['menunggu', 'diterima', 'ditolak', 'diblokir'];
        $fieldValidate = ['Teknologi', 'Pendidikan', 'Ekonomi', 'Seni dan Sastra', 'Teknik dan Industri', 'Kesehatan'];

        if (isset($confirmed_status)) {
            if (in_array($confirmed_status, $confirmedStatusValidate)) {
                $companies = $companies->where('confirmed_status', $confirmed_status);
            } else {
                return redirect()->route('bad-filter');
            }
        }
        
        if (isset($field)) {
            if (in_array($field, $fieldValidate)) {
                $companies = $companies->where('field', $field);
            } else {
                return redirect()->route('bad-filter');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Get company list',
            'data' => CompanyListResource::collection($companies),
        ]);
    }

    public function show(int $id) {
        $company = Company::find($id);

        if (is_null($company)) {
            return HttpStatus::code404('Data not found');  
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new CompanyDetailResource($company),
            ]);
        }
    }

    public function defineConfirmation(Request $request, int $id) {
        $company = Company::find($id);
        if (is_null($company)) {
            HttpStatus::code404('Data not found');
        }

        $request->validate(['confirmed_status' => 'required']);
        $company->confirmed_status = $request->confirmed_status;
        $company->save();

        return response()->json([
            'success' => true,
            'message' => 'Changes saved successfully',
            'data' => new CompanyListResource($company),
        ]);
    }
    
    public function amount(Request $request) {
        $companies = Company::all();
        $confirmed_status = $request->query('confirmed_status');
        
        $confirmedStatusValidate = ['menunggu', 'diterima', 'ditolak', 'diblokir'];

        if (isset($confirmed_status)) {
            if (in_array($confirmed_status, $confirmedStatusValidate)) {
                $companies = $companies->where('confirmed_status', $confirmed_status);
            } else {
                return redirect()->route('bad-filter');
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Get companies amount',
            'data' => ['amount' => $companies->count()],
        ]);
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

    public function getDeviceToken(int $id) {
        $company = Company::find($id);
        
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
}
