<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json([
            'message' => trans('the user was register successfully', ['attribute' => 'user']),
            'user' => $user->only(['name', 'email']),
        ], 201);
    }
}
