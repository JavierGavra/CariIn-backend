<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\FieldPractice\FieldPracticeDetailResource;
use App\Http\Resources\FieldPractice\FieldPracticeListResource;
use App\Models\FieldPractice;
use App\Models\Job;
use Illuminate\Http\Request;

class FieldPracticeController extends Controller
{
    public function index(Request $request) {
        $confirmed_status = $request->query('confirmed_status');
        $worker = auth()->user();
        $fieldPractices = $worker->fieldPractices;

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
        $worker = auth()->user();
        $fieldPractice = $worker->fieldPractices->find($id);

        if (is_null($fieldPractice)) {
            return HttpStatus::code404('Data not found');  
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new FieldPracticeDetailResource($fieldPractice),
            ]);
        }
    }

    public function create(Request $request) {
        $request->validate([
            'job_id' => 'required|integer',
            'cv_file' => 'required|file',
            'portfolio_file' => 'required|file',
            'application_letter_file' => 'required|file',
            'student_evidence_file' => 'required|file',
            'educational_institution' => 'required',
            'description' => 'required',
        ]);
        $worker = auth()->user();
        $job = Job::findOrFail($request->job_id);

        if ($job->confirmed_status == 'ditolak' || $job->pkl_status == AppFunction::booleanRequest(false)) {
            return HttpStatus::code422('This job is not allowed for this action');
        }
        if ($worker->fieldPractices->contains('job_id', $request->job_id)) {
            return HttpStatus::code409('PKL already exist for this user');
        }
        
        // File path
        $cvFilePath = 'files/field-practice/cv';
        $portfolioFilePath = 'files/field-practice/portfolio';
        $applicationLetterFilePath = 'files/field-practice/application_letter';
        $studentEvidenceFilePath = 'files/field-practice/student_evidence';
        
        // File name
        $cvFileName = AppFunction::getFileName($request->file('cv_file'));
        $portfolioFileName = AppFunction::getFileName($request->file('portfolio_file'));
        $applicationLetterFileName = AppFunction::getFileName($request->file('application_letter_file'));
        $studentEvidenceFileName = AppFunction::getFileName($request->file('student_evidence_file'));
        
        $fieldPractice = FieldPractice::create([
            'job_id' => $request->job_id,
            'worker_id' => $worker->id,
            'cv_file' => $cvFilePath . '/' . $cvFileName,
            'portfolio_file' => $portfolioFilePath . '/' . $portfolioFileName,
            'application_letter_file' => $applicationLetterFilePath . '/' . $applicationLetterFileName,
            'student_evidence_file' => $studentEvidenceFilePath . '/' . $studentEvidenceFileName,
            'educational_institution' => $request->educational_institution,
            'description' => $request->description,
            'confirmed_status' => 'mengirim',
        ]);
        
        // File store
        $request->file('cv_file')->storeAs($cvFilePath, $cvFileName);
        $request->file('portfolio_file')->storeAs($portfolioFilePath, $portfolioFileName);
        $request->file('application_letter_file')->storeAs($applicationLetterFilePath, $applicationLetterFileName);
        $request->file('student_evidence_file')->storeAs($studentEvidenceFilePath, $studentEvidenceFileName);

        if ($fieldPractice) {
            return response()->json([
                'success' => true,
                'message' => 'PKL added successfully, waiting response from company',
                'data' => $fieldPractice,
            ], 201);
        } else {
            return HttpStatus::code400('Job application failed to add');
        }
    }
}
