<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    // Ensure only admins can access this controller
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        // Fetch the activity logs with the user and post data
        $logs = ActivityLog::with('user', 'post')->latest()->paginate(10);

        return view('admin.activity_log', compact('logs'));
    }
}