<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Experience\ExperienceDetailResource;
use App\Http\Resources\Experience\ExperienceListResource;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    public function index() {
        $worker = auth()->user();
        $experiences = $worker->experiences;

        return response()->json([
            'success' => true,
            'message' => 'Get all my experience',
            'data' => ExperienceListResource::collection($experiences),
        ]);
    }
    
    public function show(int $id) {
        $worker = auth()->user();
        $experience = $worker->experiences->find($id);

        if (is_null($experience)) {
            return HttpStatus::code404('Data not found');
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new ExperienceDetailResource($experience),
            ]);
        }
    }
    
    public function create(Request $request) {
        $request->validate([
            'title' => 'required',
            'start_at' => 'required',
            'end_at' => 'nullable',
            'location' => 'required',
            'description' => 'nullable',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $worker = auth()->user();

        $data = [
            'worker_id' => $worker->id,
            'title' => $request->title,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'location' => $request->location,
            'description' => $request->description,
            'proof_image' => null,
        ];
        if ($request->hasFile('proof_image')) {
            $proofImagePath = 'images/experience/proof';
            $proofImageName = AppFunction::getImageName($request->file('proof_image'));
            $data['proof_image'] = $proofImagePath . '/' . $proofImageName;
            $request->file('proof_image')->storeAs($proofImagePath, $proofImageName);
        }
        $experience = Experience::create($data);

        if ($experience) {
            return response()->json([
                'success' => true,
                'message' => 'Success add experience',
                'data' => $experience,
            ]);
        } else {
            return HttpStatus::code400('Experience failed to add');
        }
    }
    
    public function edit(Request $request, int $id) {
        $worker = auth()->user();
        $experience = $worker->experiences->find($id);
        if (is_null($experience)) {
            return HttpStatus::code404('Data not found');
        }

        $request->validate([
            'title' => 'required',
            'start_at' => 'required',
            'end_at' => 'nullable',
            'location' => 'required',
            'description' => 'nullable',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'worker_id' => $worker->id,
            'title' => $request->title,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'location' => $request->location,
            'description' => $request->description,
            'proof_image' => $request->proof_image,
        ];

        if (isset($experience->proof_image)) {
            Storage::delete($experience->proof_image);
        }
        if ($request->hasFile('proof_image')) {
            $proofImagePath = 'images/experience/proof';
            $proofImageName = AppFunction::getImageName($request->file('proof_image'));
            $data['proof_image'] = $proofImagePath . '/' . $proofImageName;
            $request->file('proof_image')->storeAs($proofImagePath, $proofImageName);
        }
        $updateExperience = $experience->update($data);

        if ($updateExperience) {
            return response()->json([
                'success' => true,
                'message' => 'Success edit experience',
                'data' => $experience,
            ]);
        } else {
            return HttpStatus::code400('Experience edit failed');
        }
    }
    
    public function delete(int $id) {
        $worker = auth()->user();
        $experience = $worker->experiences->find($id);

        if (is_null($experience)) {
            return HttpStatus::code404('Data not found');
        } else {
            $experience->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted data',
                'data' => [],
            ]);
        }
    }
}
