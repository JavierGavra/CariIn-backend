<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Tag\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TagController extends Controller
{
    public function index() {
        $tags = Tag::all();

        return response()->json([
            'success' => true,
            'message' => 'Get all tag data',
            'data' => TagResource::collection($tags),
        ]);
    }
    
    public function create(Request $request) {
        $request->validate(['name' => 'required|unique:tags,name']);
        
        $tag = Tag::create(['name' => $request->name]);

        if ($tag) {
            return response()->json([
                'success' => true,
                'message' => 'Tag added successfully',
                'data' => new TagResource($tag),
            ]);
        } else {
            return HttpStatus::code400('Tag failed to add');
        }
    }
    
    public function delete(int $id) {
        $tag = Tag::find($id);

        if (is_null($tag)) {
            return HttpStatus::code404('Data not found');
        } else {
            $tag->jobs()->detach();
            $tag->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted data',
                'data' => [],
            ]);
        }
    }
}
