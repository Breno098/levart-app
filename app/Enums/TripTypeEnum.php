<?php

namespace App\Enums;

enum TripTypeEnum: string
{
    use EnumHelper;

    case DOMESTIC = 'domestic';
    case INTERNATIONAL = 'international';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::DOMESTIC => 'Doméstica',
            self::INTERNATIONAL  => 'Internacional',
        };
    }
}