<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RequestFriendEnum extends Enum
{
    const PENDING = 1;
    const ACCEPTED = 2;
    const BLOCKED = 3;

    public static function getTypes()
    {
        return [
            self::PENDING,
            self::ACCEPTED,
            self::BLOCKED,
        ];
    }
}