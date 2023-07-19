<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function availableTags() {
        $tags = Tag::all();

        return response()->json([
            'success' => true,
            'message' => 'Get all tag data',
            'data' => TagResource::collection($tags),
        ], 200);
    }
}
