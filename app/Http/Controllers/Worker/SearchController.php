<?php

namespace App\Http\Controllers\Worker;

use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Company\CompanyListResource;
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
        $companies = $this->companiesSearch($dbmsName, $query);

        return response()->json([
            'success' => true,
            'message' => "Get data from query",
            'data' => [
                'query' => $query,
                'jobs' => JobListResource::collection($jobs),
                'companies' => CompanyListResource::collection($companies),
            ],
        ]);
    }

    private function jobsSearch($dbmsName, $searchQuery) {
        if ($dbmsName == 'mysql') {
            $jobs = Job::where('title', 'LIKE', '%' . $searchQuery . '%')
            // ->orWhere('company.name', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'LIKE', '%' . $searchQuery . '%')
            ->orWhereHas('tags', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%');
            })
            ->orderBy('title')
            ->get();
        } else if ($dbmsName == 'pgsql') {
            $jobs = Job::where('title', 'ILIKE', '%' . $searchQuery . '%')
            // ->orWhere('company.name', 'ILIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'ILIKE', '%' . $searchQuery . '%')
            ->orWhereHas('tags', function ($query) use ($searchQuery) {
                $query->where('name', 'ILIKE', '%' . $searchQuery . '%');
            })
            ->orderBy('title')
            ->get();
        }

        return $jobs;
    }
    
    private function companiesSearch($dbmsName, $searchQuery) {
        if ($dbmsName == 'mysql') {
            $companies = Company::where('name', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('field', 'LIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'LIKE', '%' . $searchQuery . '%')
            ->get();
        } else if ($dbmsName == 'pgsql') {
            $companies = Company::where('name', 'ILIKE', '%' . $searchQuery . '%')
            ->orWhere('field', 'ILIKE', '%' . $searchQuery . '%')
            ->orWhere('description', 'ILIKE', '%' . $searchQuery . '%')
            ->get();
        }

        return $companies;
    }
}
