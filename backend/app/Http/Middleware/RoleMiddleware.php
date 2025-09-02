<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use App\Utils\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        $user = $request->user();

        if (!$user) {
            return ResponseHelper::error('Unauthorized', 401);
        }

        $allowedRoles = array_map(function ($role) {
            $constant = strtoupper($role);

            $value = constant(UserRole::class . '::' . $constant);

            return UserRole::fromValue($value);
        }, $roles);

        if (!in_array($user->role, $allowedRoles)) {
            return ResponseHelper::error('Forbidden', 403);
        }

        return $next($request);
    }
}
