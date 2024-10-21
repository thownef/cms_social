<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facades\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResource
    {
        $account = AuthService::register($request->validated());

        return new AuthResource($account);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return AuthService::login($request->validated());
    }

    public function logout()
    {
        return AuthService::logout();
    }
}
