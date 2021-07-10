<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserStatusUpdateNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('accepted')->orderBy('id')->get();
        $statuses = [
            __('Not Accepted'),
            __('Accepted'),
            __('Declined'),
        ];
        return view('admin.users.index', compact('users', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $statuses = [
            __('Not Accepted'),
            __('Accepted'),
            __('Declined'),
        ];

        $roles = Role::get()->pluck('name', 'id');

        return view('admin.users.create', compact('roles', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStoreRequest $request): \Illuminate\Http\RedirectResponse
    {


        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index')->with('status', __('User created'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $statuses = [
            __('Not Accepted'),
            __('Accepted'),
            __('Declined'),
        ];

        $roles = Role::get()->pluck('name', 'id');

        $user->load('roles');

        return view('admin.users.edit', compact('user', 'statuses', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user): \Illuminate\Http\RedirectResponse
    {
        //dd($request['last_name']);
        $user->update([
            'last_name' => $request['lastname'],
            'first_name' => $request['firstname'],
            'seal_number' => $request['seal'],
            'city' => $request['city'],
            'email' => $request['email'],
            'accepted' => $request['accepted']]);
        $user->roles()->sync($request->input('roles', []));

        if ($user->wasChanged('accepted')) {
            $user->notify(new UserStatusUpdateNotification($request->accepted));
        }

        return redirect()->back()->with('status', __('User updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', __('User deleted'));
    }
}
