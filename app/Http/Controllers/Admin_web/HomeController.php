<?php

namespace App\Http\Controllers\Admin_web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('admin.dashboard.dashboard');
    }
}
