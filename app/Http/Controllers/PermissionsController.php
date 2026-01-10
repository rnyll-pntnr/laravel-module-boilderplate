<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permissions\CreatePermissionRequest;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('permissions/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('permissions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePermissionRequest $request)
    {
        $permission = Permission::create(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('message', 'Permission created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return Inertia::render('permissions/Show', [
            'permission' => $permission,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
        ]);
        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('message', 'Permission updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('message', 'Permission deleted successfully!');
    }
}
