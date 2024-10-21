<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AuthService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'App\\Contracts\\Services\\AuthenticationServiceInterface';
    }
}
