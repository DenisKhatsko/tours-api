<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Requests\V1\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * @group Auth endpoints
 */
class LoginController
{
    /**
     * POST Login
     *
     * Login with existing user
     *
     * @response {"access_token": "1|WrE4OASS8KjHqKt3ZDlZXO5qjOQhcd3Z27At3oVSd41e3661"}
     * @response 422 {"error": "The provided credentials are invalid"}
     */
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
