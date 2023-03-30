<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'users'=> User::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request, User $user)
    {
        $user->create($request->all());

        $user = User::create($request->all());

        return redirect()->route('user.edit', $user->id)->with('message', 'Nota creada');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('Admin/Users/Show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('users.index')->with('message', 'Usuario Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('message', 'Usuario eliminado');
    }


    /**
     * To Update Status of User
     * @param Integer $user_id
     * @param Integer $Status_code
     * @return Success Response.
     */

    public function updateStatus(User $user_id, $status_code)
    {
        try {
            $update_user = User::whereId($user_id)->update([
            'status' => $status_code
            ]);
    
            if ($update_user) {
                return redirect()->route('Admin/users.index')->with('success', 'User Status Updated Successfully.');
            }
    
            return redirect()->route('Admin/users.index')->with('error', 'Fail to update user status.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
