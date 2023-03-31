<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return redirect()->route('Admin/users.index')->with('message', 'Usuario eliminado');
    }
}
