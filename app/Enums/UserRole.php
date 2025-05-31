<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'Customer';
    case Vendor = 'Vendor';
    case Admin = 'Admin';
}