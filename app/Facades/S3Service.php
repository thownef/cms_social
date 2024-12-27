<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class S3Service extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'App\\Contracts\\Services\\S3ServiceInterface';
    }
}
