<?php

namespace App\Services;

use App\Contracts\Services\AuthenticationServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function __construct()
    {
        $this->setModel();
    }
    protected $_model;

    private function setModel()
    {
        $this->_model = app()->make(\App\Models\User::class);
    }

    public function attempt($credentials): array
    {
        $account = $this->_model->where('email', '=', data_get($credentials, 'email', ''))->first();

        $isCorrectPass = $account?->checkCorrectPass(data_get($credentials, 'password'));

        if ($isCorrectPass) {
            return $this->makeToken($account);
        }

        throw new AuthenticationException;
    }

    /**
     * @param  $request
     */
    public function register($requestData): Model
    {
        return $this->_model->create($requestData);
    }

    /**
     * @param  $request
     */
    public function login($credentials): JsonResponse
    {
        $token = $this->attempt($credentials);
        return response()->json($token);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => __('message.logout_success')]);
    }

    private function makeToken($account): array
    {
        return [
            'token_type' => 'Bearer',
            'access_token' => $account->createToken($account)->plainTextToken,
            'expired_at' => now()->addMinutes(config('sanctum.expiration') ?? 0)->format('Y-m-d H:i:s'),
        ];
    }
}
