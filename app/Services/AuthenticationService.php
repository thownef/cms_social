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

    /**
     * Set model
     */
    private function setModel()
    {
        $this->_model = app()->make(User::class);
    }

    /**
     * Attempt to login
     * @param array $credentials
     * @return JsonResponse
     */
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
     * Register new user
     * @param array $requestData
     * @return JsonResponse
     */
    public function register($requestData): JsonResponse
    {
        $data = collect($requestData)->only(['login_type', 'first_name', 'last_name', 'email', 'password', 'phone'])->toArray();
        $account = $this->_model->create($data);
        return $this->httpOK($account, UserTransformer::class);
    }

    /**
     * Login user
     * @param array $credentials
     * @return JsonResponse
     */
    public function login($credentials): JsonResponse
    {
        return $this->attempt($credentials);
    }

    /**
     * Make token
     * @param Model $account
     * @return JsonResponse
     */
    private function makeToken($account): JsonResponse
    {
        $token = $account->createToken($account);
        return $this->httpOK($token, TokenTransformer::class);
    }

    /**
     * Logout user
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $this->httpOK(['message' => __('message.logout_success')]);
    }
    /**
     * Get current user
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return $this->httpOK(auth()->user(), UserTransformer::class);
    }

    /**
     * Refresh token
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $user = auth()->user();

        $user->currentAccessToken()->delete();

        $token = $user->createToken($user)->plainTextToken;

        return $this->httpOK($token, TokenTransformer::class);
    }
}
