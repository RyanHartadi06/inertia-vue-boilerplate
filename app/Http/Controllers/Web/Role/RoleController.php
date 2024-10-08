<?php

namespace App\Http\Controllers\Web\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Role\UpdateRoleRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resources      = Role::with('users', 'permissions')->get();

        return Inertia::render('Role/Index', [
            'title'         => 'Role Permission',
            'resources'     => $resources,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return Inertia::render('Role/Show', [
            'title'         => 'Detail Role',
            'resource'      => $role->load('users', 'permissions'),
            'role_name'     => $role->name,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions        = config('permissions');
        $resource           = $role->load('users', 'permissions');
        $savedPermissions   = $resource->permissions->pluck('name')->toArray();

        return Inertia::render('Role/Edit', [
            'title'             => 'Edit Role',
            'resource'          => $resource,
            'savedPermissions'  => $savedPermissions,
            'permissions'       => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();

            foreach ($request->permissions as $permission) {
                Permission::firstOrCreate(['name'  => $permission]);
            }
    
            $role->syncPermissions($request->permissions);

            DB::commit();
    
            return redirect()->route('roles.index')->with('success', 'Role has been updated.');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Failed to update role.');
        }
    }
}
