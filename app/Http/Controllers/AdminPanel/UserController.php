<?php

namespace App\Http\Controllers\AdminPanel;

use App\Actions\User\ChangeStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $query = User::latest()->where('id', '!=', auth()->id());

        if ($request->q) {
            $query->where(function ($query) use ($request) {
                $query->where('id', 'LIKE', "%$request->q%")
                    ->orWhere('name', 'LIKE', "%$request->q%")
                    ->orWhere('email', 'LIKE', "%$request->q%");
            });
        }

        $users = $query->paginate(15, ['id', 'name', 'email', 'status']);

        return Inertia::render('AdminPanel/Users/Index', [
            'users' => $users,
        ]);
    }

    public function show(User $user): Response
    {
        return Inertia::render('AdminPanel/Users/Show', compact('user'));
    }

    public function edit(User $user): Response
    {
        return Inertia::render('AdminPanel/Users/Edit', compact('user'));
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()->route('users.index')->with('message', 'Usuario Actualizado');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index')->with('message', 'Usuario eliminado');
    }

    public function changeStatus(ChangeStatus $changeStatus, Request $request): JsonResponse
    {
        $changeStatus->handle($request);

        return response()->json(['success' => 'Status change successfully.']);
    }
}
