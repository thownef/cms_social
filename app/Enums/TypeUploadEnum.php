<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TypeUploadEnum extends Enum
{
    const Avatar = 'avatar';
    const Cover = 'cover';
    const Post = 'post';

    public static function getTypes() {
        return [
            self::Avatar,
            self::Cover,
            self::Post,
        ];
    }
}
