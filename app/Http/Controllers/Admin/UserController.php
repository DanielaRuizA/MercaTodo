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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $user->update($request->all());

        return redirect()->route('users.index')->with('message', 'Usuario Actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('message', 'Usuario eliminado');
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);

        $user->status = $request->status;

        $user->save();

        return redirect()->route('users.index')->response()->json(['success'=>'Status change successfully.']);
    }
}
