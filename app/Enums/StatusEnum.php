<?php

namespace App\Enums;

enum StatusEnum:string
{
    case ACTIVE = '1';
    case INACTIVE = '0';
    
    public static function lists(): array
    {
        return array_combine(
            array_column(self::cases(), 'name'),
            array_column(self::cases(), 'value')
        );
    }
    public static function name($status)
    {
        return match($status) {
            1 => 'Active',
            0 => 'In Active'
        };
    }
}
