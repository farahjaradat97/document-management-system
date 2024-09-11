<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'Admin';
    case USER = 'User';
    case SUPER_ADMIN = 'superAdmin';
}
