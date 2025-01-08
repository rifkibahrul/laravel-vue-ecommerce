<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Settlement = 'Settlement';
    case pending = 'pending';
    case Expire = 'Expire';

    public static function getStatuses()
    {
        return [
            self::pending,
            self::Settlement,
            self::Expire
        ];
    }
}
