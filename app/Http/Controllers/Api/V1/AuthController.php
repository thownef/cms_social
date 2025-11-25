<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\AuthService;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Supports\Traits\HasTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    use HasTransformer;

    public function register(RegisterRequest $request): JsonResponse
    {
        return AuthService::register($request->validated());
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return AuthService::login($request->validated());
    }

    public function logout(): JsonResponse
    {
        return AuthService::logout();
    }

    public function me(): JsonResponse
    {
        return AuthService::me();
    }

    public function refresh(): JsonResponse
    {
        return AuthService::refresh();
    }
}
