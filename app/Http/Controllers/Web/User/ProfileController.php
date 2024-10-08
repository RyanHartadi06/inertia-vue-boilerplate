<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Libraries\Helpers\RouteHelper;
use App\Models\User\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Profile/Show', [
            'title'         => 'Profil',
            'resource'      => auth('web')->user()->load('roles.permissions'),
            'breadcrumbs'   => [
                ['title' => 'Profil', 'url' => route('profile.index')],
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'title'         => 'Edit Profil',
            'resource'      => auth('web')->user()->load('roles'),
            'breadcrumbs'   => [
                ['title' => 'Profil', 'url' => route('profile.index')],
                ['title' => 'Edit', 'url' => route('profile.edit')],
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = User::find(auth('web')->user()->id);
        $user->fill($request->all());
        $user->avatar = $request->hasFile('avatar') ?
            $request->avatar->storeAs('avatars', $request->file('file')->getClientOriginalName(), 'public') :
            RouteHelper::ImageUrlToDb($request->avatar);
        $user->save();
        return redirect()->route('profile.index')->with('success', 'Profile is updated successfully.');
    }
}
