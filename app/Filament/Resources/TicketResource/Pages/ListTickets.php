<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Enums\TicketStatusEnum;
use App\Filament\Resources\TicketResource;
use App\Models\Ticket;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('Todas')->badge(Ticket::query()->count())->icon('heroicon-o-rectangle-stack'),
        ];

        foreach (TicketStatusEnum::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->label())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('ticket_status', $status))
                ->icon($status->icon())
                ->badgeColor($status->color())
                ->badge(Ticket::query()->where('ticket_status', $status)->count());
        }

        return $tabs;
    }
    }
