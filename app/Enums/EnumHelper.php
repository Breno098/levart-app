<?php

namespace App\Enums;

use Illuminate\Support\Arr;

trait EnumHelper
{
    /**
     * @return array
     */
    public static function toValuesWithLabels(): array
    {
        return  array_combine(
            self::toValues(),
            self::toLabels()
        );
    }

    /**
     * @return array
     */
    public static function toValues(): array
    {
        return Arr::map(self::cases(), function($case) {
            return $case->value;
        });
    }

    /**
     * @return array
     */
    public static function toLabels(): array
    {
        return Arr::map(self::cases(), function($case) {
            return method_exists(self::class, 'label') ? $case->label() : $case->name;
        });
    }
}