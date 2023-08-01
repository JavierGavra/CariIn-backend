<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company\admin\CompanyDetailResource;
use App\Http\Resources\Company\admin\CompanyListResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request) {
        $confirmed_status = $request->query('confirmed_status');
        
        $confirmedStatusValidate = ['menunggu', 'diterima', 'ditolak', 'diblokir'];

        if (isset($confirmed_status)) {
            if (in_array($confirmed_status, $confirmedStatusValidate)) {
                $companies = Company::where('confirmed_status', $confirmed_status)->get();
            } else {
                return redirect()->route('bad-filter');
            }
        } else {
            $companies = Company::all();
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
}
