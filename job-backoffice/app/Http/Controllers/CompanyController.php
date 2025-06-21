<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public $industries;

    public function __construct()
    {
        $this->industries = ['Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Manufacturing', 'Other'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = Company::latest();

        // Archived archived
        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        $companies = $query->paginate(10)->onEachSide(1);
        return view("company.index", compact("companies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        
        return view("company.create", compact("industries", "roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validated = $request->validated();
        
        //Create company owner
        $owner = User::create([
            "name"=> $validated["owner_name"],
            "email"=> $validated["owner_email"],
            "password"=> Hash::make($validated["owner_password"]),
            "role"=> "company-owner",
        ]);

        // Fails create owner
        if (!$owner) {
            return redirect()->route("company.create")->with('notification', [
                'title' => 'Error!',
                'type' => 'error',
                'message' => 'Failed to create company owner.',
            ]);
        }

        //Create company
        Company::create([
            "name"=> $validated["name"],
            "address"=> $validated["address"],
            "industry"=> $validated["industry"],
            "website"=> $validated["website"],
            "owner_id"=> $owner->id,
        ]);

        return redirect()->route("company.index")->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'Company added successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);        
        return view("company.show", compact("company"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);

        $industries = $this->industries;

        return view("company.edit", compact("company", "industries"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $company = Company::findOrFail($id);
        $company->update([
            "name"=> $validated["name"],
            "address"=> $validated["address"],
            "industry"=> $validated["industry"],
            "website"=> $validated["website"],
        ]);

        // Update company owner
        $ownerData = [];
        $ownerData["name"] = $validated["owner_name"];

        if ($validated["owner_password"]) {
            $ownerData["password"] = Hash::make($validated["owner_password"]);
        }

        $company->owner()->update($ownerData);

        if($request->query('redirectToList')){ 
            return redirect()->route("company.index")->with('notification', [
                'title'=> 'Success!',
                'type'=> 'success',
                'message'=> 'Company updated successfully.',
            ]);
        }

        return redirect()->route("company.show", $id)->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'Company updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route("company.index")->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'Company archived successfully.'
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route("company.index", ['archived' => 'true'])->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'Company restored successfully.'
        ]);
    }
}
