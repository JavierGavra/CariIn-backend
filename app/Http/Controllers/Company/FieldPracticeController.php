<?php

namespace App\Http\Controllers\Company;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\FieldPractice\FieldPracticeDetailResource;
use App\Http\Resources\FieldPractice\FieldPracticeListResource;
use App\Models\FieldPractice;
use Illuminate\Http\Request;

class FieldPracticeController extends Controller
{
    public function index(Request $request) {
        $confirmed_status = $request->query('confirmed_status');
        $company = auth()->user();
        $fieldPractices = FieldPractice::whereIn('job_id', $company->jobs->pluck('id'))->get();

        $confirmedStatusValidate = ['mengirim', 'direview', 'wawancara', 'diterima', 'ditolak'];
        
        if (isset($confirmed_status)) {
            if (in_array($confirmed_status, $confirmedStatusValidate)){
                $fieldPractices = $fieldPractices->where('confirmed_status', $confirmed_status);
            } else {
                return redirect()->route('bad-filter');
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Get all my PKL data',
            'data' => FieldPracticeListResource::collection($fieldPractices),
        ]);
    }

    public function show(int $id) {
        $company = auth()->user();
        $fieldPractice = FieldPractice::whereIn('job_id', $company->jobs->pluck('id'))->find($id);

        if (is_null($fieldPractice)) {
            return HttpStatus::code404('Data not found');  
        } else {
            if ($fieldPractice->confirmed_status == "mengirim") {
                $fieldPractice->confirmed_status = "direview";
                $fieldPractice->save();
            }
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new FieldPracticeDetailResource($fieldPractice),
            ]);
        }
    }

    public function defineConfirmation(Request $request, int $id) {
        $company = auth()->user();
        $fieldPractice = FieldPractice::whereIn('job_id', $company->jobs->pluck('id'))->find($id);
        if (is_null($fieldPractice)) {
            return HttpStatus::code404('Data not found');  
        }

        $confirmedStatusValidate = ["wawancara", "diterima", "ditolak"]; 
        $request->validate(['confirmed_status' => 'required']);
        if(!in_array($request->confirmed_status, $confirmedStatusValidate)) {
            return HttpStatus::code400();
        }

        $fieldPractice->confirmed_status = $request->confirmed_status;
        $fieldPractice->save();

        return response()->json([
            'success' => true,
            'message' => 'Changes saved successfully',
            'data' => new FieldPracticeDetailResource($fieldPractice),
        ]);
    }
}
