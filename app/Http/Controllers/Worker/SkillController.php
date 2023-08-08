<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Skill\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index() {
        $worker = auth()->user();
        $skills = $worker->skills;
        
        return response()->json([
            'success' => true,
            'message' => "Get all my skill",
            'data' => SkillResource::collection($skills),
        ]);
    }
    
    public function create(Request $request) {
        $request->validate(['name' => 'required']);
        $worker = auth()->user();
        
        if ($worker->skills->contains('name', $request->name)) {
            return HttpStatus::code409('You already have this skill');
        }
        
        $skill = Skill::create([
            'name' => $request->name,
            'worker_id' => $worker->id,
        ]);

        if ($skill) {
            return response()->json([
                'success' => true,
                'message' => "Success add skill",
                'data' => $skill,
            ]);
        } else {
            return HttpStatus::code400('Skill failed to add');
        }
    }
    
    public function delete(int $id) {
        $worker = auth()->user();
        $skill = $worker->skills->find($id);

        if (is_null($skill)) {
            return HttpStatus::code404('Data not found');
        } else {
            $skill->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted data',
                'data' => [],
            ]);
        }
    }
}
