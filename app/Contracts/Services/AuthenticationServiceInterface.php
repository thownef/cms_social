<?php

namespace App\Contracts\Services;

interface AuthenticationServiceInterface
{
    public function attempt($credentials);
    public function register($request);
    public function login($request);
    public function logout();
}
