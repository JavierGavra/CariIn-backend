<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurriculumVitae\CurriculumVitaeResource;
use App\Models\CurriculumVitae;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurriculumVitaeController extends Controller
{
    public function index() {
        $worker = auth()->user();

        return response()->json([
            'success' => true,
            'message' => 'Get my curriculum vitae',
            'data' => new CurriculumVitaeResource($worker->curriculumVitae),
        ]);
    }

    public function create(Request $request) {
        $request->validate(['cv_file' => 'required|file']);
        $worker = auth()->user();

        if (isset($worker->curriculumVitae)) {
            return HttpStatus::code409('You already have CV');
        }
        $cvFilePath = 'files/curriculum-vitae';
        $cvFileName = AppFunction::getFileName($request->file('cv_file'));
        $curriculumVitae = CurriculumVitae::create([
            'worker_id' => $worker->id,
            'cv_file' => $cvFilePath . '/' . $cvFileName,
        ]);
        $request->file('cv_file')->storeAs($cvFilePath, $cvFileName);

        if ($curriculumVitae) {
            return response()->json([
                'success' => true,
                'message' => 'Get my curriculum vitae',
                'data' => $curriculumVitae,
            ]);
        } else {
            return HttpStatus::code400('Curriculum vitae failed to add');
        }
    }
    
    public function edit(Request $request) {
        $request->validate(['cv_file' => 'required|file']);
        $worker = auth()->user();
        $curriculumVitae = $worker->curriculumVitae;

        if (is_null($curriculumVitae)) {
            return HttpStatus::code404('You dont have CV');
        }
        
        Storage::delete($curriculumVitae->cv_file);
        $cvFilePath = 'files/curriculum-vitae';
        $cvFileName = AppFunction::getFileName($request->file('cv_file'));
        $curriculumVitae->cv_file = $cvFilePath . '/' . $cvFileName;
        $curriculumVitae->cv_file = $cvFilePath . '/' . $cvFileName;
        $request->file('cv_file')->storeAs($cvFilePath, $cvFileName);
        $curriculumVitae->save();

        return response()->json([
            'success' => true,
            'message' => "successful change CV",
            'data' => [],
        ]);
    }
}
