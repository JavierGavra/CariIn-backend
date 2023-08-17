<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Education\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index() {
        $worker = auth()->user();
        $educations = $worker->educations;

        return response()->json([
            'success' => true,
            'message' => 'Get all my educations',
            'data' => EducationResource::collection($educations),
        ]);
    }
    
    public function create(Request $request) {
        $request->validate([
            'educational_institution' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'title' => 'nullable',
            'description' => 'nullable',
        ]);
        $worker = auth()->user();
        
        if ($worker->educations->contains('educational_institution', $request->educational_institution)) {
            return HttpStatus::code409('You already have this education');
        }
        
        $education = Education::create([
            'worker_id' => $worker->id,
            'educational_institution' => $request->educational_institution,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($education) {
            return response()->json([
                'success' => true,
                'message' => "Success add education",
                'data' => $education,
            ]);
        } else {
            return HttpStatus::code400('Education failed to add');
        }
    }
    
    public function edit(Request $request, int $id) {
        $worker = auth()->user();
        $education = $worker->educations->find($id);
        if (is_null($education)) {
            return HttpStatus::code404("Data not found");
        }

        $request->validate([
            'educational_institution' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'title' => 'nullable',
            'description' => 'nullable',
        ]);
        
        $updateEducation = $education->update([
            'educational_institution' => $request->educational_institution,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($updateEducation) {
            return response()->json([
                'success' => true,
                'message' => "Success add education",
                'data' => $education,
            ]);
        } else {
            return HttpStatus::code400('Education failed to add');
        }
    }

    public function delete(int $id) {
        $worker = auth()->user();
        $education = $worker->educations->find($id);

        if (is_null($education)) {
            return HttpStatus::code404('Data not found');
        } else {
            $education->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted data',
                'data' => [],
            ]);
        }
    }
}
