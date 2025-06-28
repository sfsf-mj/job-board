<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->guard()->user()->role == "admin")
        {
            $analytics = $this->adminDashboardAnalytics();
        } else {
            $analytics = $this->companyDashboardAnalytics();
        }
        return view('dashboard.index', compact('analytics'));
    }

    private function adminDashboardAnalytics()
    {
                // Last 30 days active users
        $activeUsers = User::where("last_login_at", ">=", now()->subDays(30))
            ->where("role", "job-seeker")->count();

        // Total jobs (not deleted)
        $totalJobVacancies = JobVacancy::whereNull("deleted_at")->count();

        // Total applications (not deleted)
        $totalJobApplications = JobApplication::whereNull("deleted_at")->count();

        // Most applied jobs
        $mostAppliedJobs = JobVacancy::withCount("jobApplications as totalCount")
            ->whereNull("deleted_at")
            ->orderByDesc("totalCount")
            ->limit(5)
            ->get();

        // Conversion rate
        $conversionRates = JobVacancy::withCount("jobApplications as totalCount")
            ->having("totalCount", ">", 0)
            ->whereNull("deleted_at")
            ->orderByDesc("totalCount")
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->view_count > 0) {
                    $job->conversionRate = round($job->totalCount / $job->view_count * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });

        $analytics = [
            "activeUsers" => $activeUsers,
            "totalJobVacancies" => $totalJobVacancies,
            "totalJobApplications" => $totalJobApplications,
            "mostAppliedJobs" => $mostAppliedJobs,
            "conversionRates" => $conversionRates
        ];

        return $analytics;
    }

    private function companyDashboardAnalytics()
    {
        $company = auth()->guard()->user()->company;

        // Last 30 days active users
        $activeUsers = User::where("last_login_at", ">=", now()->subDays(30))
            ->where("role", "job-seeker")
            ->whereHas("jobApplications", function ($query) use ($company) {
                $query->whereIn("job_vacancy_id", $company->jobVacancies->pluck("id"));
            })
            ->count();

        // Total jobs (not deleted)
        $totalJobVacancies = $company->jobVacancies->whereNull("deleted_at")->count();

        // Total applications (not deleted)
        $totalJobApplications = JobApplication::whereNull("deleted_at")
            ->whereIn("job_vacancy_id", $company->jobVacancies->pluck("id"))
            ->count();

        // Most applied jobs
        $mostAppliedJobs = JobVacancy::withCount("jobApplications as totalCount")
            ->whereNull("deleted_at")
            ->whereIn("id", $company->jobVacancies->pluck("id"))
            ->orderByDesc("totalCount")
            ->limit(5)
            ->get();

        // Conversion rate
        $conversionRates = JobVacancy::withCount("jobApplications as totalCount")
            ->whereNull("deleted_at")
            ->whereIn("id", $company->jobVacancies->pluck("id"))
            ->having("totalCount", ">", 0)
            ->orderByDesc("totalCount")
            ->limit(5)
            ->get()
            ->map(function ($job) {
                if ($job->view_count > 0) {
                    $job->conversionRate = round($job->totalCount / $job->view_count * 100, 2);
                } else {
                    $job->conversionRate = 0;
                }
                return $job;
            });

        $analytics = [
            "activeUsers" => $activeUsers,
            "totalJobVacancies" => $totalJobVacancies,
            "totalJobApplications" => $totalJobApplications,
            "mostAppliedJobs" => $mostAppliedJobs,
            "conversionRates" => $conversionRates
        ];

        return $analytics;
    }
}
