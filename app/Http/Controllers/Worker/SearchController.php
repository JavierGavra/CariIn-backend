<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Job\JobListResource;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchQuery(Request $request) {
        $query = $request->query('query');

        if (is_null($query)) {
            return HttpStatus::code400("Search query has not set");
        }

        $dbmsName = env('DB_CONNECTION');
        $jobs = $this->jobsSearch($dbmsName, $query);

        return response()->json([
            'success' => true,
            'message' => "Get data from query",
            'data' => [
                'query' => $query,
                'job' => JobListResource::collection($jobs),
            ],
        ]);
    }

    private function jobsSearch($dbmsName, $searchQuery) {
        if ($dbmsName == 'mysql') {
            $jobs = Job::where('title', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'LIKE', '%' . $searchQuery . '%')
            ->orWhereHas('tags', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%');
            })
            ->orderBy('title')
            ->get();
        } else if ($dbmsName == 'pgsql') {
            $jobs = Job::where('title', 'ILIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'ILIKE', '%' . $searchQuery . '%')
            ->orWhereHas('tags', function ($query) use ($searchQuery) {
                $query->where('name', 'ILIKE', '%' . $searchQuery . '%')
                    ->orderBy('name');
            })
            ->orderBy('title')
            ->get();
        }

        return $jobs;
    }
}
