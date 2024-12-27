<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facades\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Supports\Traits\HasTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use HasTransformer;
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $data = collect($validated)->only(['login_type', 'first_name', 'last_name', 'email', 'password', 'phone'])->toArray();
        $account = AuthService::register($data);
        return $this->httpOK($account, UserTransformer::class);
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
}
