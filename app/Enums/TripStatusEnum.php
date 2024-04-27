<?php

namespace App\Enums;

enum TripStatusEnum: string
{
    use EnumHelper;

    case SCHEDULED = 'scheduled';
    case CANCELLED = 'cancelled';
    case DELAYED = 'delayed';
    case COMPLETED = 'completed';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::SCHEDULED => 'Agendado',
            self::CANCELLED  => 'Cancelado',
            self::DELAYED  => 'Atrasado',
            self::COMPLETED  => 'Concluído',
        };
    }

     /**
     * @return string
     */
    public function color(): string
    {
        return match($this) {
            self::SCHEDULED => 'gray',
            self::CANCELLED  => 'danger',
            self::DELAYED  => 'info',
            self::COMPLETED  => 'success',
        };
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return match($this) {
            self::SCHEDULED => 'heroicon-c-paper-airplane',
            self::CANCELLED  => 'heroicon-o-x-circle',
            self::DELAYED  => 'heroicon-o-x-circle',
            self::COMPLETED  => 'heroicon-o-check-circle',
        };
    }
}