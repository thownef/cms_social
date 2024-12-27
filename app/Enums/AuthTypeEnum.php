<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AuthTypeEnum extends Enum
{
    const Admin = 1;
    const User = 2;

    public static function getTypes() {
        return [
            self::Admin,
            self::User ,
        ];
    }
}
