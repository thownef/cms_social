<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TypeFriendEnum extends Enum
{
    const ACQUAINTANCE = 1;
    const CLOSE = 2;
    const RESTRICTED = 3;

    public static function getTypes()
    {
        return [
            self::CLOSE,
            self::ACQUAINTANCE,
            self::RESTRICTED,
        ];
    }
}
