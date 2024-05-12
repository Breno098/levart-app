<?php

namespace App\Enums;

enum CurrencyEnum: string
{
    use EnumHelper;

    case EUR = 'EUR';
    case USD = 'USD';
    case BRL = 'BRL';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::EUR => 'Euro',
            self::USD => 'Dólar',
            self::BRL => 'Real',
        };
    }

     /**
     * @return string
     */
    public function signal(): string
    {
        return match($this) {
            self::EUR => "€",
            self::USD => "$",
            self::BRL => "R$",
        };
    }
}