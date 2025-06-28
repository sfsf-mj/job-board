<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationUpdateRequest;
use App\Models\JobApplication;
use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobApplication::latest();

        $searchValue = $request->input("search") ?? "";
        
        if (!empty($searchValue)) {
            $query->where('status', 'like', '%' . $searchValue . '%')
                ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                ->orWhere('job_vacancy_id', 'like', '%' . $searchValue . '%')
                ->get();
        }

        if (auth()->guard()->user()->role == "company-owner") {
            $query->whereHas("jobVacancy", function ($query) {
                $query->where("company_id", auth()->guard()->user()->company->id);
            });
        }

        // Archived archived
        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        $jobApplications = $query->paginate(10)->onEachSide(1);
        return view("job-application.index", ['search' => $searchValue], compact("jobApplications"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view("job-application.show", compact("jobApplication"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Get JobApplication
        $jobApplication = JobApplication::findOrFail($id);

        return view("job-application.edit", compact(["jobApplication"]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->update([
            "status" => $validated["status"],
        ]);

        if ($request->query('redirectToList')) {
            return redirect()->route("job-application.index")->with('notification', [
                'title' => 'Success!',
                'type' => 'success',
                'message' => 'JobApplication updated successfully.',
            ]);
        }

        return redirect()->route("job-application.show", $id)->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'JobApplication updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route("job-application.index")->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'JobApplication archived successfully.'
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();
        return redirect()->route("job-application.index", ['archived' => 'true'])->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'JobApplication restored successfully.'
        ]);
    }
}
