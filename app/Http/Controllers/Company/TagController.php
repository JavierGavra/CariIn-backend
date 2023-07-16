<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(int $id) {
        $company = auth()->user();
        $job = $company->jobs->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Get my job data',
            'data' => TagResource::collection($job->tags),
        ], 200);
    }
}
