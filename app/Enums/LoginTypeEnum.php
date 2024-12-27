<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LoginTypeEnum extends Enum
{
    const NORMAL = 1;
    const FACEBOOK = 2;
    const GOOGLE = 3;
    const GITHUB = 4;

    public static function getTypes() {
        return [
            self::NORMAL,
            self::FACEBOOK,
            self::GOOGLE,
            self::GITHUB,
        ];
    }
}
