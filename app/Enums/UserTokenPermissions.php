<?php

namespace App\Enums;

enum UserTokenPermissions: String
{
    case All = '*';

    public static function everything(): array
    {
        return array_column(UserTokenPermissions::cases(), 'value');
    }
}
