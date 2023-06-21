<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;

class ChangeUserStatusAction
{
    public function handle(Request $request): void
    {
        $user = User::find($request->user_id);

        $user->status = $request->status;

        $user->save();
    }
}
