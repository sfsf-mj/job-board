<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobVacancy::latest();

        if (auth()->guard()->user()->role == "company-owner") {
            $query->where("company_id", auth()->guard()->user()->company->id);
        }

        // Archived archived
        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(10)->onEachSide(1);
        return view("job-vacancy.index", compact("jobVacancies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get Companies
        $companies = Company::all();

        // Get Job Categories
        $jobCategories = JobCategory::all();

        return view("job-vacancy.create", compact("companies", "jobCategories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();

        //Create JobVacancy
        JobVacancy::create($validated);

        return redirect()->route("job-vacancy.index")->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'JobVacancy added successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);        
        return view("job-vacancy.show", compact("jobVacancy"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Get Companies
        $companies = Company::all();

        // Get Job Categories
        $jobCategories = JobCategory::all();

        // Get JobVacancy
        $jobVacancy = JobVacancy::findOrFail($id);
        
        return view("job-vacancy.edit", compact(["jobVacancy", "companies", "jobCategories"]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $JobVacancy = JobVacancy::findOrFail($id);
        $JobVacancy->update($validated);

        if($request->query('redirectToList')){ 
            return redirect()->route("job-vacancy.index")->with('notification', [
                'title' => 'Success!',
                'type' => 'success',
                'message' => 'JobVacancy updated successfully.',
            ]);
        }

        return redirect()->route("job-vacancy.show", $id)->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'JobVacancy updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $JobVacancy = JobVacancy::findOrFail($id);
        $JobVacancy->delete();
        return redirect()->route("job-vacancy.index")->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'JobVacancy archived successfully.'
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $JobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $JobVacancy->restore();
        return redirect()->route("job-vacancy.index", ['archived' => 'true'])->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'JobVacancy restored successfully.'
        ]);
    }
}
