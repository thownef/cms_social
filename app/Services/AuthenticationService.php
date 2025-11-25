<?php

namespace App\Services;

use App\Contracts\Services\AuthenticationServiceInterface;
use App\Models\User;
use App\Supports\Traits\HasTransformer;
use App\Transformers\TokenTransformer;
use App\Transformers\UserTransformer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class AuthenticationService implements AuthenticationServiceInterface
{
    use HasTransformer;

    public function __construct()
    {
        $this->setModel();
    }
    protected $_model;

    private function setModel()
    {
        $this->_model = app()->make(User::class);
    }

    public function attempt($credentials): JsonResponse
    {
        $account = $this->_model->where('email', '=', data_get($credentials, 'email', ''))->first();
        $isCorrectPass = $account?->checkCorrectPass(data_get($credentials, 'password'));

        if ($isCorrectPass) {
            return $this->makeToken($account);
        }

        throw new AuthenticationException;
    }

    public function register($requestData): JsonResponse
    {
        $data = collect($requestData)->only(['login_type', 'first_name', 'last_name', 'email', 'password', 'phone'])->toArray();
        $account = $this->_model->create($data);
        return $this->httpOK($account, UserTransformer::class);
    }

    public function login($credentials): JsonResponse
    {
        return $this->attempt($credentials);
    }

    private function makeToken($account): JsonResponse
    {
        $token = $account->createToken($account);
        return $this->httpOK($token, TokenTransformer::class);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->httpOK(['message' => __('message.logout_success')]);
    }

    public function me(): JsonResponse
    {
        return $this->httpOK(auth()->user(), UserTransformer::class);
    }

    public function refresh(): JsonResponse
    {
        $user = auth()->user();

        $user->currentAccessToken()->delete();

        $token = $user->createToken($user)->plainTextToken;

        return $this->httpOK($token, TokenTransformer::class);
    }
}
