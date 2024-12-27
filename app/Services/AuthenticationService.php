<?php

namespace App\Services;

use App\Contracts\Services\AuthenticationServiceInterface;
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
        $this->_model = app()->make(\App\Models\User::class);
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
}
