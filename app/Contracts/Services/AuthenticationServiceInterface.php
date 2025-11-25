<?php

namespace App\Contracts\Services;

interface AuthenticationServiceInterface
{
    public function attempt($credentials);

    public function register($data);

    public function login($data);

    public function logout();

    public function refresh();

    public function me();
}
