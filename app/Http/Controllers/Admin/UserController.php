<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\Controller;
//use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'users'=> User::latest()->get()
        ]);
    }

    public function show(User $user)
    {
        return Inertia::render('Admin/Users/Show', compact('user'));
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return redirect()->route('users.index')->with('message', 'Usuario Actualizado');
    }

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
                return redirect()->route('users.index')->with('success', 'User Status Updated Successfully.');
            }
    
            return redirect()->route('users.index')->with('error', 'Fail to update user status.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}