<?php

namespace App\Enums;

enum TicketStatusEnum: string
{
    use EnumHelper;

    case ISSUED = 'issued';
    case USED = 'used';
    case CANCELLED = 'cancelled';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::ISSUED => 'Emitida',
            self::USED  => 'Utilizada',
            self::CANCELLED  => 'Cancelado',
        };
    }

     /**
     * @return string
     */
    public function color(): string
    {
        return match($this) {
            self::ISSUED => 'gray',
            self::USED  => 'success',
            self::CANCELLED  => 'danger',
        };
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return match($this) {
            self::ISSUED => 'heroicon-c-paper-airplane',
            self::USED  => 'heroicon-o-check-circle',
            self::CANCELLED  => 'heroicon-o-x-circle',
        };
    }
}