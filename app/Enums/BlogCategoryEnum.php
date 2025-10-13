<?php

namespace App\Enums;

enum BlogCategoryEnum:string
{
    case BLOG = 'blog';
    
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
            'blog' => 'BLOG',
        };
    }
}
