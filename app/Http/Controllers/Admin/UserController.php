<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users/Index', [
            'users' => User::where('id', '!=', auth()->id())
                ->latest()
                ->paginate(15, ['id', 'name', 'email', 'status'])
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

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->route('users.index')->with('message', 'Usuario Actualizado');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('message', 'Usuario eliminado');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        return Inertia::render('Admin/Users/Index', [
        'users' => User::query()
        ->Where('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->get()
    ]);
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);

        $user->status = $request->status;

        $user->save();

        return response()->json(['success' => 'Status change successfully.']);
    }
}
