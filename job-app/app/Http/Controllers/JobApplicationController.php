<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $jobApplications = JobApplication::where('user_id', auth()->guard()->user()->id)
            ->latest()
            ->paginate(5);

        return view('job-applications.index' , compact('jobApplications'));
    }
}
