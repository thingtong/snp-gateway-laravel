<?php

namespace App\Enums;

enum UserRoles: String
{
    case Root = 'root';
    case Admin = 'admin';
    case User = 'user';

    public function label(): string
    {
        return match ($this->value) {
            UserRoles::Root->value => 'Root',
            UserRoles::Admin->value => 'Admin',
            UserRoles::User->value => 'User',
        };
    }
}
