<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\AuthService;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Supports\Traits\HasTransformer;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    use HasTransformer;

    /**
     * Register new user
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return AuthService::register($request->validated());
    }

    /**
     * Login user
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return AuthService::login($request->validated());
    }

    /**
     * Logout user
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return AuthService::logout();
    }

    /**
     * Get current user
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return AuthService::me();
    }

    /**
     * Refresh token
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return AuthService::refresh();
    }
}
