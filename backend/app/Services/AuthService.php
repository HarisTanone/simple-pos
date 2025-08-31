<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use App\Utils\ResponseHelper;

class AuthService
{
    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return ResponseHelper::error('Invalid credentials', 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ResponseHelper::success([
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer'
        ], 'Login successful');
    }

    public function logout(User $user)
    {
        $user->currentAccessToken()->delete();

        return ResponseHelper::success(null, 'Logout successful');
    }

    public function me(User $user)
    {
        return ResponseHelper::success(new UserResource($user));
    }
}
