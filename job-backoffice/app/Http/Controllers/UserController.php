<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = User::latest();

        // Archived archived
        if ($request->input("archived") == "true") {
            $query->onlyTrashed();
        }

        $users = $query->paginate(10)->onEachSide(1);
        return view("user.index", compact("users"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Get User
        $user = User::findOrFail($id);

        return view("user.edit", compact(["user"]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $user = User::findOrFail($id);
        $user->update([
            "password" => Hash::make($validated["password"]),
        ]);

        if ($request->query('redirectToList')) {
            return redirect()->route("user.index")->with('notification', [
                'title' => 'Success!',
                'type' => 'success',
                'message' => 'User updated successfully.',
            ]);
        }

        return redirect()->route("user.show", $id)->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'User updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route("user.index")->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'User archived successfully.'
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route("user.index", ['archived' => 'true'])->with('notification', [
            'title' => 'Success!',
            'type' => 'success',
            'message' => 'User restored successfully.'
        ]);
    }
}
