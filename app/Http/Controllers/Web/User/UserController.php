<?php

namespace App\Http\Controllers\Web\User;

use App\Enums\RoleType;
use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRequestByName;
use App\Http\Requests\Web\User\UpdateUserRequest;
use App\Models\User\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequestByName $request)
    {
        $filters = [];

        $resources = User::with('roles')
            ->filterResource($request, ['name', 'email', 'username'], $filters)
            ->orderBy($request->get('sort', 'name'), $request->get('order', 'asc'))
            ->paginate($request->per_page);

        return Inertia::render('User/Index', array_merge($this->simpleResourceAdditionalData($request, $resources, $filters), [
            'title'         => 'User',
            'resources'     => $resources,
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return Inertia::render('User/Show', [
            'title'         => 'Detail User',
            'resource'      => $user->load('roles.permissions'),
            'role_name'     => $user->roles->count() > 0 ? $user->roles[0]->name : '-',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('User/Edit', [
            'title'         => 'Edit User',
            'pageTitle'     => 'User',
            'resource'      => $user->load('roles'),
            'selectedRoles' => $user->roles->pluck('name'),
            'roles'         => Role::get()->map(function ($item) {
                return [
                    'value' => $item->id,
                    'label' => $item->name,
                ];
            })
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with('success', 'Data updated successfully');   
    }
}
