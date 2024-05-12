<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    use EnumHelper;

    case CREDIT_CARD = 'credit_card';
    case DEBIT_CARD = 'debit_card';
    case PAYPAL = 'paypal';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::CREDIT_CARD => 'Cartão de Crédito',
            self::DEBIT_CARD => 'Cartão de Debito',
            self::PAYPAL => 'Paypal',
        };
    }
}