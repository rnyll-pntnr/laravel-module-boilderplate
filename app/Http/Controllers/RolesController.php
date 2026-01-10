<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Roles\CreateRoleRequest;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('roles/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('roles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name]);
        return redirect()->route('roles.index')->with('message', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $role->permissions;
        return Inertia::render('roles/Show', [
            'role' => $role,
            'permissions' => Permission::all()->toArray(),
            'ticked_permissions' => $permissions->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        
        // Only update name if provided
        if ($request->has('name')) {
            $role->update(['name' => $request->name]);
        }
        
        // Sync permissions if provided
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }
        
        return redirect()->route('roles.index')->with('message', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('message', 'Role deleted successfully!');
    }


}
