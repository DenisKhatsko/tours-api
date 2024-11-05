<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Requests\V1\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $user = User::query()->where('email', '=', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are invalid'], 422);
        }
        $device = substr($request->userAgent() ?? [], 0, 255);

        return response()->json(['access_token' => $user->createToken($device)->plainTextToken]);
    }
}
