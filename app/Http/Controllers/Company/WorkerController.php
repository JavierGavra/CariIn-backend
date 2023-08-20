<?php

namespace App\Http\Controllers\Company;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceToken\DeviceTokenResource;
use App\Http\Resources\Education\EducationResource;
use App\Http\Resources\Experience\ExperienceDetailResource;
use App\Http\Resources\Experience\ExperienceListResource;
use App\Http\Resources\Skill\SkillResource;
use App\Http\Resources\Worker\WorkerDetailResource;
use App\Http\Resources\Worker\WorkerListResource;
use App\Models\Worker;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function index() {
        $workers = Worker::where('company_visible', 1)->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Get workers list',
            'data' => WorkerListResource::collection($workers),
        ]);
    }

    public function show(int $id) {
        $worker = Worker::find($id);
        
        if (is_null($worker)) {
            return HttpStatus::code404("Data not found");
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new WorkerDetailResource($worker),
            ]);
        }
    }
    
    public function getDeviceToken(int $id) {
        $worker = Worker::find($id);
        
        if (is_null($worker)) {
            return HttpStatus::code404("Data not found");
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => new DeviceTokenResource($worker),
            ]);
        }
    }
    
    public function getExperiences(int $id) {
        $worker = Worker::find($id);
        
        if (is_null($worker)) {
            return HttpStatus::code404("Data not found");
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => ExperienceListResource::collection($worker->experiences),
            ]);
        }
    }
    
    public function showExperience(int $id, int $experience_id) {
        $worker = Worker::find($id);
        if (is_null($worker)) {
            return HttpStatus::code404("Data not found");
        }

        $experience = $worker->experiences->find($experience_id);
        if (is_null($experience)) {
            return HttpStatus::code404("Data not found");
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Data found',
            'data' =>new ExperienceDetailResource($experience),
        ]);
        
    }

    public function getEducations(int $id) {
        $worker = Worker::find($id);
        
        if (is_null($worker)) {
            return HttpStatus::code404("Data not found");
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => EducationResource::collection($worker->educations),
            ]);
        }
    }

    public function getSkills(int $id) {
        $worker = Worker::find($id);
        
        if (is_null($worker)) {
            return HttpStatus::code404("Data not found");
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data found',
                'data' => SkillResource::collection($worker->skills),
            ]);
        }
    }
}
