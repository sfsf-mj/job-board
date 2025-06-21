<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;
use Illuminate\Http\Request;
use App\Models\JobCategory;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobCategory::latest();

        // Archived archived
        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        $categories = $query->paginate(10)->onEachSide(1);
        return view("jop-category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("jop-category.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        $validated = $request->validated();
        JobCategory::create($validated);
        return redirect()->route("job-category.index")->with('notification', [
                'title' => 'Success!',
                'type' => 'success',
                'message' => 'Category added successfully.'
            ]);;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        return view("jop-category.edit", compact("jobCategory"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->update($validated);
        return redirect()->route("job-category.index")->with('notification', [
                'title' => 'Success!',
                'type' => 'success',
                'message' => 'Category updated successfully.'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->delete();
        return redirect()->route("job-category.index")->with('notification', [
                'title' => 'Success!',
                'type' => 'success',
                'message' => 'Category archived successfully.'
            ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobCategory = JobCategory::withTrashed()->findOrFail($id);
        $jobCategory->restore();
        return redirect()->route("job-category.index", ['archived' => 'true'])->with('notification', [
                'title' => 'Success!',
                'type' => 'success',
                'message' => 'Category restored successfully.'
            ]);
    }
}
